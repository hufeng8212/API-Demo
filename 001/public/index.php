<?php
// 指定编码
header("Content-Type:text/json;charset=utf-8;");
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');

// 响应头设置
//header('Access-Control-Allow-Headers:x-requested-with,content-type,version');


// 获取请求接口版本
//define('VERSION', isset($_SERVER['HTTP_VERSION']) ? $_SERVER['HTTP_VERSION'] : '1.0.0');
// 定义绝对路径常量
define('BASE_PATH', dirname(__DIR__));
define('LOG_PATH', BASE_PATH . '/log');
//define('APP_PATH', BASE_PATH . '/app' . '/' . VERSION);
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', APP_PATH . '/config');
define('INI_CONFIG_PATH', CONFIG_PATH . '/config.ini');
define('PHP_CONFIG_PATH', CONFIG_PATH . '/config.php');


// 导入自定义异常处理代码
require_once "exception.php";


// 注册自动加载器
use Phalcon\Loader;

$loader = new Loader();
$loader->registerDirs([
    APP_PATH . '/controllers/',
    APP_PATH . '/models/',
    APP_PATH . '/library/',
]);
$loader->register();


// 创建容器
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;

$di = new FactoryDefault();

// 设置视图组件
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

//use Phalcon\Mvc\Url as UrlProvider;
//// 设置基础URL
//$di->set(
//    'url',
//    function () {
//        $url = new UrlProvider();
//        $url->setBaseUri('/');
//        return $url;
//    }
//);

// 初始化请求环境
use Phalcon\Mvc\Application;

$application = new Application($di);
$response = $application->handle();
//$response->send();