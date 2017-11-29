<?php

class Controller {

    public function __construct() {
        require_once 'DB_Operations.php';
        require_once 'Model.php';

        //Incluir todos los modelos
        foreach (glob("model/*.php") as $file) {
            require_once $file;
        }
    }

    # Plugins y funcionalidades

    /*
     * Este método lo que hace es recibir los datos del controlador en forma de array
     * los recorre y crea una variable dinámica con el indice asociativo y le da el 
     * valor que contiene dicha posición del array, luego carga los helpers para las
     * vistas y carga la vista que le llega como parámetro. En resumen un método para
     * renderizar vistas.
     */
    public function view($vista, $datos) {
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc} = $valor;
        }

        require_once 'core/View.php';
        $helper = new View();

        require_once "view/{$vista}View.php";
    }

    public function redirect($controlador = DEFAULT_CONTROLLER, $accion = DEFAULT_ACTION) {
        header("Location:index.php?controller={$controlador}&action={$accion}");
    }

    
    # Funciones contenidas en el antiguo ControladorFrontal.func.php
    
    public function cargarControlador($controller) {
	$controlador = ucwords($controller) . 'Controller';
	$strFileController = "controller/{$controlador}.php";

	if (!is_file($strFileController)) {
	    $strFileController = 'controller/' . ucwords(DEFAULT_CONTROLLER) . 'Controller.php';
	}

	require_once $strFileController;
	$controllerObj = new $controlador();
	return $controllerObj;
    }

    private function cargarAccion($controllerObj, $action) {
	$accion = $action;
	$controllerObj->$accion();
    }

    public function lanzarAccion($controllerObj) {
	$action = filter_input(INPUT_GET, "action");
	if (isset($action) && method_exists($controllerObj, $action)) {
	    $this->cargarAccion($controllerObj, $action);
	} else {
	    $this->cargarAccion($controllerObj, DEFAULT_ACTION);
	}
    }
}
