<?php

//FUNCIONES PARA EL CONTROLADOR FRONTAL

function cargarControlador($controller) {
    $controlador = ucwords($controller) . 'Controller';
    $strFileController = "controller/{$controlador}.php";

    if (!is_file($strFileController)) {
        $strFileController = 'controller/' . ucwords(CONTROLADOR_DEFECTO) . 'Controller.php';
    }

    require_once $strFileController;
    $controllerObj = new $controlador();
    return $controllerObj;
}

function cargarAccion($controllerObj, $action) {
    $accion = $action;
    $controllerObj->$accion();
}

function lanzarAccion($controllerObj) {
    $action = filter_input(INPUT_GET, "action");
    if (isset($action) && method_exists($controllerObj, $action)) {
        cargarAccion($controllerObj, $action);
    } else {
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}
