<?php


define ('SLASH', DIRECTORY_SEPARATOR);
define ('DIRECTOR_SITE', dirname(__FILE__));
require_once 'autoloader/autoloader.php';

if (isset($_GET['action'])) {
    $controller = new MapController();
    $controller->handleRequest();
} else {
    $googleMapsApiKey = 'AIzaSyDQz3eIc4qVe1iNkZaehSEz94GhJRxkPP0'; 
    $view = new MapView($googleMapsApiKey);
    $view->render();
}
