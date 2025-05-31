<?php

function autoload($class)
{
    //Autoloader de la laborator.
    if (file_exists(DIRECTOR_SITE . SLASH . 'database' . SLASH . strtolower($class) . '.php')) {
        require_once DIRECTOR_SITE . SLASH . 'database' . SLASH . strtolower($class) . '.php';
    } else if (file_exists(DIRECTOR_SITE . SLASH . 'models' . SLASH . strtolower($class) . '.php')) {
        require_once DIRECTOR_SITE . SLASH . 'models' . SLASH . strtolower($class) . '.php';
    } else if (file_exists(DIRECTOR_SITE . SLASH . 'views' . SLASH . strtolower($class) . '.php')) {
        require_once DIRECTOR_SITE . SLASH . 'views' . SLASH . strtolower($class) . '.php';
    } else if (file_exists(DIRECTOR_SITE . SLASH . 'controllers' . SLASH . strtolower($class) . '.php')) {
        require_once DIRECTOR_SITE . SLASH . 'controllers' . SLASH . strtolower($class) . '.php';
    }
}

spl_autoload_register('autoload');
