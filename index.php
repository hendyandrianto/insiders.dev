<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

//session_start();

define('ROOT', dirname(__FILE__));
define('CACHE', false);
define('MODULE_DIR', ROOT . '/modules/');
define('CACHE_DIR', ROOT . '/views/templates/cache/');

require_once(ROOT.'/components/Autoload.php'); // Подключение файлов системы

$router = new Router();

if(CACHE && !isset($_GET['build'])){
    $router->cache();
}

$modules = new ModuleController();

$router->run();
