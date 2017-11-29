<?php

class Controller {

    public function __construct() {
	require_once 'DB_Operations.php';
	require_once 'Model.php';

	//Incluir todos los modelos
	foreach (glob(PATH_MODEL . "*.php") as $file) {
	    require_once $file;
	}
    }

    # Plugins y funcionalidades

    /**
     * Este método recibe datos del controlador en forma de array
     * los recorre y crea una variable dinámica con el indice asociativo
     * y le da el valor que contiene dicha posición del array,
     * luego carga los helpers para las vistas y carga la vista
     * que le llega como parámetro.
     * @param string $view_name Nombre de la vista
     * @param array $data Datos del controlador en array
     */
    public function view($view_name, $data) {
	foreach ($data as $id_assoc => $value) {
	    ${$id_assoc} = $value;
	}

	require_once 'core/View.php';
	$helper = new View();

	require_once "view/{$view_name}View.php";
    }

    public function redirect($controller = '', $action = '') {
	if(empty($controller)) {
	    $controller = DEFAULT_CONTROLLER;
	}
	if(empty($action)) {
	    $action = DEFAULT_ACTION;
	}
	header("Location:index.php?controller={$controller}&action={$action}");
    }

    # Funciones contenidas en el antiguo ControladorFrontal.func.php

    public function loadController($controller) {
	$controlador = ucwords($controller) . 'Controller';
	$strFileController = "controller/{$controlador}.php";

	if (!is_file($strFileController)) {
	    $strFileController = 'controller/' . ucwords(DEFAULT_CONTROLLER) . 'Controller.php';
	}

	require_once $strFileController;
	$controllerObj = new $controlador();
	return $controllerObj;
    }

    private function loadAction($controllerObj, $action) {
	$accion = $action;
	$controllerObj->$accion();
    }

    public function executeAction($controllerObj) {
	$action = filter_input(INPUT_GET, "action");
	if (isset($action) && method_exists($controllerObj, $action)) {
	    $this->loadAction($controllerObj, $action);
	} else {
	    $this->loadAction($controllerObj, DEFAULT_ACTION);
	}
    }

}
