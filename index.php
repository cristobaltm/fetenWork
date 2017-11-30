<?php

// Configuración global
require_once 'core/global.php';

// Base para los controladores
require_once 'core/Controller.php';

// Recuperamos las variables pasadas por GET
$var_controller = filter_input(INPUT_GET, GET_CONTROLLER);
$var_action = filter_input(INPUT_GET, GET_ACTION);

// Cargamos controladores y acciones
$controller = new Controller();
$controller->loadController($var_controller);
$controller->executeAction($var_action);
