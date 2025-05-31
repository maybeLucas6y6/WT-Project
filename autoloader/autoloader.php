<?php

function autoload($class)
{
    $path = DIRECTOR_SITE . SLASH . 'database' . SLASH . strtolower($class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        echo "Nu găsesc clasa $class";
        exit();
    }
}

spl_autoload_register('autoload');
