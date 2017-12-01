<?php

class Controller {
    
    # Atributos

    private $controller = null;
    private $view = null;
    protected $model = null;

    # Constructor y destructor

    /**
     *  Controlador base
     */
    public function __construct() {
	// Incluir el Modelo base
	require_once 'Model.php';
	// Incluir la vista Base
	require_once 'View.php';

	// Carga el objeto View
	$this->view = new View();
    }

    function __destruct() {
	
    }

    # Setters
    
    protected function setModel($model) {
	$this->model = $model;
    }

        
    # Métodos

    /**
     * Carga el controlador 
     * @param string $controller_name Nombre del controlador
     */
    public function loadController($controller_name) {
	// Define el controlador y la ruta del fichero
	$controller = ucwords($controller_name) . 'Controller';
	$strFileController = PATH_CONTROLLERS . $controller . ".php";

	// Si no existe el fichero, carga el controlador por defecto
	if (!is_file($strFileController)) {
	    $controller = DEFAULT_CONTROLLER . 'Controller';
	    $strFileController = PATH_CONTROLLERS . $controller . ".php";
	}

	// Incluye el fichero y carga el controlador
	require_once $strFileController;
	$this->controller = new $controller();
    }

    /**
     * Ejecuta la acción correspondiente del controlador
     * @param string $action Nombre de la acción
     * @return bool resultado de la acción
     */
    public function executeAction($action) {
	// Si no existe el método dentro del controlador,
	// ejecuta la acción por defecto
	if (!method_exists($this->controller, $action)) {
	    $action = DEFAULT_ACTION;
	}

	// Ejecuta la acción
	return $this->controller->$action();
    }

    /**
     * Este método recibe datos del controlador en forma de array
     * los recorre y crea una variable dinámica con el indice asociativo
     * y le da el valor que contiene dicha posición del array,
     * luego carga los helpers para las vistas y carga la vista
     * que le llega como parámetro.
     * @param string $view_name Nombre de la vista
     * @param array $data Datos del controlador en array
     */
    public function view($view_name, $data = array()) {
	// Define la vista y la ruta del fichero
	$view = ucwords($view_name) . 'View';
	$strFileView = PATH_VIEWS . $view . ".php";

	// Si no existe el fichero, carga la vista por defecto
	if (!is_file($strFileView)) {
	    $view = DEFAULT_VIEW . 'View';
	    $strFileView = PATH_VIEWS . $view . ".php";
	}
	
	require_once $strFileView;
	$this->view = new $view();
	$this->view->mergeReplace($data);
	$this->view->write();	
    }

    /**
     * Redirige a la página correspondiente, pasando los parámetros requeridos
     * @param string $controller Controlador
     * @param string $action Acción 
     */
    public function redirect($controller = '', $action = '') {
	$url = $this->view->url($controller, $action);
	header("Location:{$url}");
    }

}
