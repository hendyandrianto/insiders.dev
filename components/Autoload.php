<?php

spl_autoload_register(function ($class) {
    
    // Массив папок, в которых могут находиться необходимые классы
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );
    
    foreach ($array_paths as $path) {
        $path = ROOT . $path . $class . '.php';
        
        if (is_file($path)) {
            include_once $path;
        }
    }
});