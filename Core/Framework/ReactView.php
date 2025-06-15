<?php

namespace Core\Framework;

class ReactView
{
    private static string $version = '1.0.0';
    private static array $sharedData = [];

    public static function render(string $component, array $props = []): string
    {
        // 共有データとマージ
        $mergedProps = array_merge(self::$sharedData, $props);

        $pageProps = [
            'component' => $component,
            'props' => $mergedProps,
            'url' => $_SERVER['REQUEST_URI'],
            'version' => self::$version,
        ];

        if (self::isReactViewRequest()) {
            header('Content-Type: application/json');
            return json_encode($pageProps);
        }

        // 通常のHTMLレスポンス
        return self::renderHtmlWithProps($pageProps);
    }

    private static function isReactViewRequest(): bool
    {
        return isset($_SERVER['HTTP_X_INERTIA']) && $_SERVER['HTTP_X_INERTIA'] === 'true';
    }

    private static function renderHtmlWithProps(array $pageProps): string
    {
        // CSRFトークンを追加
        $csrfToken = self::generateCsrfToken();
        $pageJson = htmlspecialchars(json_encode($pageProps), ENT_QUOTES, 'UTF-8');
        
        return <<<HTML
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{$csrfToken}">
    <title>Mini Framework</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div id="app" data-page="{$pageJson}"></div>
    <script src="/js/app.js"></script>
</body>
</html>
HTML;
    }

    /**
     * CSRFトークンを生成
     */
    private static function generateCsrfToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['_token'];
    }

    /**
     * バージョンを設定
     */
    public static function setVersion(string $version): void
    {
        self::$version = $version;
    }

    /**
     * バージョンを取得
     */
    public static function getVersion(): string
    {
        return self::$version;
    }
} 