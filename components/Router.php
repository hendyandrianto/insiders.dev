<?php

class Router {

    private $routes;
    private $result;
    private $matches;

    public function __construct() {
        // Путь к файлу с роутами
        $routesPath = ROOT . '/config/routes.php';

        // Получаем роуты из файла
        $this->routes = include($routesPath);
    }

    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }
    }

    public function run() {

        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri, $this->matches)) {
                array_shift($this->matches);
                $class = $path['class'];
                $action = $path['method'];
                $params = isset($this->matches) ? $this->matches : [];

                if ($class == 'HomeController' && $uri !== '/') {
                    $content = false;
                    header("HTTP/1.0 404 Not Found");
                    require_once(ROOT . '/views/templates/page_errors.php');
                    exit();
                }

                $controllerFile = ROOT . '/controllers/' . $class . '.php';

                include_once($controllerFile);

                $controllerObj = new $class;

                $this->result = call_user_func_array([$controllerObj, $action], $params);

                if ($this->result != null) {
                    break;
                }
            }
        }
    }

    public function cache() {
        $uri = $this->getURI();
        $link_parts = explode('/', $uri);
        $slug = array_pop($link_parts);
        $category = array_pop($link_parts);
        $cache_filename = CACHE_DIR . $category . '_' . $slug . '.html';
        if (file_exists($cache_filename)) {
            require_once $cache_filename;  
            exit;
        }
    }

}
