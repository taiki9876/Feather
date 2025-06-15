<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Framework\Router;
use Core\Framework\Logger;
use Core\Framework\Config;
use Core\Framework\Session;
use Core\Framework\Request;
use Core\Framework\Application;
use App\Presentation\RoutingDefinition;

// 環境変数の読み込み
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// 設定ファイルの読み込み
Config::load(__DIR__ . '/../config/app.php');
Config::load(__DIR__ . '/../config/database.php');

// アプリケーションの初期化
$app = new Application();

// ServiceProviderの登録
$providers = require __DIR__ . '/../config/providers.php';
$app->registerServiceProviders($providers['providers']);

// アプリケーションの起動
$app->boot();

// セッションの開始
Session::start();

$container = $app->getContainer();
$router = new Router($container);
$logger = new Logger();
$request = new Request();

// ルートの定義
RoutingDefinition::define($router);

try {
    $method = $request->getMethod();
    $uri = $request->getUri();
    
    $logger->info("Request: {$method} {$uri}");
    
    $response = $router->dispatch($method, $uri);
    echo $response;
} catch (\Exception $e) {
    $logger->error($e->getMessage());
    http_response_code(404);
    echo '404 Not Found';
} 