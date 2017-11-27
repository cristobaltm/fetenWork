<?php

//Configuración global
require_once 'config/global.php';

//Base para los controladores
require_once 'core/ControladorBase.php';

//Funciones para el controlador frontal
require_once 'core/ControladorFrontal.func.php';

//Cargamos controladores y acciones
$controller = filter_input(INPUT_GET, "controller");
if (!empty($controller)) {
    $controllerObj = cargarControlador($controller);
} else {
    $controllerObj = cargarControlador(CONTROLADOR_DEFECTO);
}
lanzarAccion($controllerObj);
