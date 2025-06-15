import React from "react";
import { createRoot, Root } from "react-dom/client";

interface ReactViewPage {
  component: string;
  props: any;
  url: string;
  version?: string;
}

interface ReactViewResponse {
  component: string;
  props: any;
  url: string;
  version?: string;
}

class ReactView {
  private root: Root | null = null;
  private container: HTMLElement | null = null;
  private components: { [key: string]: React.ComponentType<any> } = {};
  private currentPage: ReactViewPage | null = null;
  private decryptionKey: string = "";

  // コンポーネントを登録
  registerComponents(components: { [key: string]: React.ComponentType<any> }) {
    this.components = { ...this.components, ...components };
  }

  // 初期化
  async init(container: HTMLElement, reactViewPage: ReactViewPage) {
    this.container = container;

    this.currentPage = reactViewPage;
    this.root = createRoot(container);
    this.render(reactViewPage);
    this.setupLinkHandlers();
  }

  // メタタグから復号化キーを取得
  private getDecryptionKeyFromMeta(): string {
    const metaTag = document.querySelector(
      'meta[name="react-view-key"]'
    ) as HTMLMetaElement;
    return metaTag ? metaTag.content : "";
  }

  // propsを復号化
  private async decryptProps(encryptedProps: string): Promise<any> {
    if (!this.decryptionKey || !encryptedProps) {
      console.error("Decryption key or props missing");
      return {};
    }

    try {
      return await this.decryptData(encryptedProps, this.decryptionKey);
    } catch (error) {
      console.error("Failed to decrypt props:", error);
      return {};
    }
  }

  // データを復号化
  private async decryptData(encryptedData: string, key: string): Promise<any> {
    try {
      // Base64デコード
      const combined = Uint8Array.from(atob(encryptedData), (c) =>
        c.charCodeAt(0)
      );

      // IV (16 bytes) + encrypted data を分離
      const iv = combined.slice(0, 16);
      const encrypted = combined.slice(16);

      // キーをArrayBufferに変換
      const keyBuffer = Uint8Array.from(atob(key), (c) => c.charCodeAt(0));

      // Web Crypto APIで復号化
      const cryptoKey = await crypto.subtle.importKey(
        "raw",
        keyBuffer,
        { name: "AES-CBC" },
        false,
        ["decrypt"]
      );

      const decrypted = await crypto.subtle.decrypt(
        {
          name: "AES-CBC",
          iv: iv,
        },
        cryptoKey,
        encrypted
      );

      // ArrayBufferを文字列に変換してJSONパース
      const jsonString = new TextDecoder().decode(decrypted);
      return JSON.parse(jsonString);
    } catch (error) {
      console.error("Decryption error:", error);
      throw error;
    }
  }

  // ページをレンダリング
  private render(page: ReactViewPage) {
    if (!this.root) return;

    const Component = this.components[page.component];
    if (!Component) {
      console.error(`Component ${page.component} not found`);
      return;
    }

    this.root.render(React.createElement(Component, page.props));

    // URLを更新
    if (page.url !== window.location.pathname) {
      window.history.pushState({}, "", page.url);
    }
  }

  // リンクのクリックハンドラーを設定
  private setupLinkHandlers() {
    document.addEventListener("click", (e) => {
      const target = e.target as HTMLElement;
      const link = target.closest("a[href]") as HTMLAnchorElement;

      if (!link || link.target === "_blank" || link.href.startsWith("http")) {
        return;
      }

      e.preventDefault();
      this.visit(link.href);
    });

    // ブラウザの戻る/進むボタン対応
    window.addEventListener("popstate", () => {
      this.visit(window.location.pathname, { replace: true });
    });
  }

  // ページ遷移
  async visit(url: string, options: { replace?: boolean } = {}) {
    try {
      const response = await fetch(url, {
        headers: {
          "HTTP_X_INERTIA": "true",
          "HTTP_X_INERTIA_VERSION": this.currentPage?.version || "",
          Accept: "application/json",
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      const pageResponse: ReactViewResponse = await response.json();

      // propsを復号化
      const decryptedProps = await this.decryptProps(pageResponse.props);
      const page = {
        ...pageResponse,
        props: decryptedProps,
      };

      this.currentPage = page;
      this.render(page);
    } catch (error) {
      console.error("Navigation failed:", error);
      // フォールバック: 通常のページ遷移
      window.location.href = url;
    }
  }

  // フォーム送信
  async post(url: string, data: any = {}) {
    try {
      const formData = new FormData();
      Object.keys(data).forEach((key) => {
        formData.append(key, data[key]);
      });

      const response = await fetch(url, {
        method: "POST",
        headers: {
          "X-Inertia": "true",
          "X-Inertia-Version": this.currentPage?.version || "",
          Accept: "application/json",
        },
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      const pageResponse: ReactViewResponse = await response.json();

      // propsを復号化
      const decryptedProps = await this.decryptProps(pageResponse.props);
      const page = {
        ...pageResponse,
        props: decryptedProps,
      };

      this.currentPage = page;
      this.render(page);
    } catch (error) {
      console.error("Form submission failed:", error);
    }
  }

  // 現在のページ情報を取得
  getCurrentPage(): ReactViewPage | null {
    return this.currentPage;
  }
}

// グローバルインスタンス
export const reactView = new ReactView();

// グローバルに公開
declare global {
  interface Window {
    reactView: ReactView;
  }
}

window.reactView = reactView;
