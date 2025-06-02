<?php

define('SLASH', DIRECTORY_SEPARATOR);

function autoload($class) {
    // echo "Searching for $class<br/>";
    foreach (['controllers', 'models', 'views', 'database'] as $folder) {
        $path = __DIR__ . SLASH . $folder . SLASH . $class . '.php';
        if (file_exists($path)) {
            // echo "Found $path<br/>";
            require_once($path);
            return;
        }
    }
}

spl_autoload_register('autoload');
