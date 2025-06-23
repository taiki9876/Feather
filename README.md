# Feather - 軽量 PHP フレームワーク

**Feather**は、PHP で構築された Web フレームワークです。
View は React SSR との統合しております。
依存性注入コンテナ、クリーンアーキテクチャの設計原則を採用し、効率的で保守性の高い Web アプリケーションの開発を支援します。
Laravel とにたユーティリティを持ちます。

素のPHPでフレームワークを作成してみようという試みです。
またAIコーディングを試す場として、主にcursor(claude-4-sonnet)を使って遊んでいます。

## コンセプト

このフレームワークは以下の原則に基づいて設計されています：

- **軽量性**: 必要最小限の機能に絞った軽量なフレームワーク
- **モジュラー設計**: 疎結合で拡張可能なアーキテクチャ
- **React 統合**: React SSR との自然な統合
- **クリーンアーキテクチャ**: Domain、UseCase、Infrastructure、Presentation の分離
- **開発者体験**: 直感的な API と開発ツールの提供

## 主な機能

- ✅ **ルーティングシステム** - 柔軟な HTTP ルーティング
- ✅ **依存性注入コンテナ** - 自動的な依存解決
- ✅ **React View 統合** - React SSR サポート
- ✅ **設定管理** - 環境変数ベースの設定
- [ ] **データベース接続** - PDO ベースのデータベース抽象化(作成中)
- [ ] **リクエスト/レスポンス** - HTTP 処理の抽象化
- [ ] **ロギング** - 構造化ログ出力(作成中)
- ✅ **デバッグツール** - 開発時のデバッグ支援

## 🛠️ システム要件

- PHP >= 8.0
- Node.js >= 14.x
- Composer
- npm

## 📦 インストール・ビルド方法

### 1. 依存関係のインストール

```bash
# すべての依存関係を一括インストール
make install

# または個別にインストール
composer install
npm install
```

### 2. フロントエンドのビルド

```bash
# CSS/Sassのビルド
make build-css

# 開発時のCSSウォッチング
make watch-css

# React/TypeScriptのビルド
npm run build
```

### 3. 開発サーバーの起動

```bash
# PHPビルトインサーバーを起動
make serve

# 開発環境の一括セットアップ・起動
make dev
```

## 🏗️ アプリケーションの作成方法

### 1. ディレクトリ構造

```
App/
├── Domain/           # ドメインロジック・エンティティ
├── UseCase/          # ビジネスロジック
├── Infrastructure/   # データアクセス・外部連携
├── Presentation/     # コントローラー・プレゼンテーション層
└── Providers/        # サービスプロバイダー
```

### 2. UseCase の作成

```bash
# UseCaseクラスを自動生成
make usecase NAME=CreateUser
```

これにより、以下のファイルが自動生成されます：

- `App/UseCase/CreateUserUseCase.php`
- 対応するインターフェースとテンプレート

### 3. ルート定義

`App/Presentation/RouteingDifinition.php`

```php
<?php

namespace App\Presentation;

use Core\Framework\Router;
use App\Presentation\Controller\Hello\HelloController;
use App\Presentation\Controller\User\UserController;

class RoutingDefinition
{
    public static function define(Router $router): void
    {
        $router->get('/', [HelloController::class, 'index']);
        $router->get('/{id}', [HelloController::class, 'show']);
        $router->get('/users', [UserController::class, 'index']);
        $router->get('/users/{id}', [UserController::class, 'show']);

    }
}
```

### 4. コントローラーの作成

```php
<?php
// App/Presentation/Controllers/UserController.php

namespace App\Presentation\Controllers;

use Core\Framework\Request;
use Core\Framework\ReactView;
use App\UseCase\User\FetchUserListUseCase;

class UserController
{
    public function __construct(
        private FetchUserListUseCase $fetchUserListUseCase,
        private ReactView $view
    ) {}

    public function index(): string
    {
        $input = new FetchUserListUseCaseInput();
        $output = $this->fetchUserListUseCase->execute(input);

        return ReactView::render(
            component: "User/UserList",
            props: ["users" => $output->users],
        );
    }
}
```

## ⚛️ React View の使い方

### 1. React View の準備

React コンポーネントは `frontend/src/pages` ディレクトリに配置：

```typescript
import {User, UserListMeta} from "../types";

export type Props = {
    users: User[];
}
export const UserListPage = ({ users }: Props) => {
  return (
    <div className="user-list-container">
      <div className="user-list-card">
        <h1 className="user-list-title">ユーザー一覧</h1>
    //省略
```
### 2. コンポーネントの登録
```typescript
// frontend/src/app.tsx
reactView.registerComponents({
    Welcome: WelcomePage,
    "Users/Index": UserListPage,
    "Users/Show": UserDetailPage,
    "Users/NotFound": UserNotFoundPage,
});
```
キーとコンポーネントを一致するように指定します。
```php
//PHP 使用例：コントローラーにて
return ReactView::render(
    component: "User/UserList",
    props: ["users" => $output->users],
);
```

### 2. CSS/Sass の使用

```scss
// frontend/scss/app.scss
.user-list {
  padding: 20px;

  .user-card {
    background: #f5f5f5;
    padding: 15px;
    margin: 10px 0;
    border-radius: 8px;

    h3 {
      margin: 0 0 5px 0;
      color: #333;
    }

    p {
      margin: 0;
      color: #666;
    }
  }
}
```

## 📁 設定ファイル

### アプリケーション設定

- `config/app.php` - 基本設定
- `config/database.php` - データベース設定(作成中)
- `config/providers.php` - サービスプロバイダー設定

### 環境変数

`.env` ファイルで環境固有の設定を管理：

```env
APP_DEBUG=true
DB_HOST=localhost
DB_NAME=myapp
DB_USERNAME=root
DB_PASSWORD=
```

## 🚧 現在実装されていない機能

これらはまだ実装していない TODO です。

### 認証・認可システム

- ❌ ログイン/ログアウト機能
- ❌ セッション管理（基本的な機能のみ）
- ❌ パスワードハッシュ化
- ❌ JWT トークン認証
- ❌ OAuth 連携

### ミドルウェアシステム

- ❌ ルートミドルウェア
- ❌ グローバルミドルウェア
- ❌ 認証ミドルウェア
- ❌ CORS ミドルウェア

### その他の高度な機能

- ❌ ORM（Eloquent 等）
- ❌ キューシステム
- ❌ キャッシュレイヤー
- ❌ ファイルアップロード処理
- ❌ メール送信機能
- ❌ 多言語化（i18n）
- ❌ パフォーマンス最適化（Redis 等）
