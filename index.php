<?php

// Configuración global
require_once 'config/global.php';

// Base para los controladores
require_once 'core/Controller.php';

// Cargamos controladores y acciones
$controller = new Controller();

$var_controller = filter_input(INPUT_GET, "controller");

if (empty($var_controller)) {
    $controllerObj = $controller->loadController(DEFAULT_CONTROLLER);
    
} else {
    $controllerObj = $controller->loadController($var_controller);
}

$controller->executeAction($controllerObj);
