<?php

class Controller {

	# Atributos

	private $controller = null;
	protected $view = null;
	protected $model = null;

	# Constructor y destructor

	/**
	 *  Controlador base
	 */
	public function __construct() {
		// Incluir la clase de conexión a Base de Datos
		require_once 'DBConnection.php';
		// Incluir el Modelo base
		require_once 'Model.php';
		// Incluir la vista Base
		require_once 'View.php';
	}

	function __destruct() {
		
	}

	# Métodos

	/**
	 * Carga el controlador, y si no existe carga el de por defecto
	 * @param string $name Nombre del controlador
	 */
	private function loadController($name) {
		// Define el controlador y la ruta del fichero
		$controller = ucwords($name) . 'Controller';
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
	 * Carga el modelo, y si no existe carga el de por defecto
	 * @param string $name Nombre modelo
	 */
	protected function loadModel($name) {
		// Define el modelo y la ruta del fichero
		$model = ucwords($name) . 'Model';
		$strFileModel = PATH_MODELS . $model . ".php";

		// Si no existe el fichero, carga el modelo por defecto
		if (!is_file($strFileModel)) {
			$model = DEFAULT_CONTROLLER . 'Model';
			$strFileModel = PATH_MODEL . $model . ".php";
		}

		// Incluye el fichero y carga el modelo
		require_once $strFileModel;
		$this->model = new $model();
	}

	/**
	 * Carga la vista, y si no existe carga la de por defecto
	 * @param string $name Nombre de la vista
	 */
	protected function loadView($name) {
		// Define la vista y la ruta del fichero
		$view = ucwords($name) . 'View';
		$strFileView = PATH_VIEWS . $view . ".php";

		// Si no existe el fichero, carga la vista por defecto
		if (!is_file($strFileView)) {
			$view = DEFAULT_CONTROLLER . 'View';
			$strFileView = PATH_VIEWS . $view . ".php";
		}

		// Incluye el fichero y carga la vista
		require_once $strFileView;
		$this->view = new $view();
	}

	/**
	 * Carga el controlador llamando al método loadController
	 * @param string $name Nombre del controlador
	 */
	public function load($name) {
		$this->loadController($name);
	}

	/**
	 * Ejecuta la acción correspondiente del controlador
	 * @param string $action Nombre de la acción
	 * @return bool resultado de la acción
	 */
	public function execute($action) {
		// Si no existe el método dentro del controlador,
		// ejecuta la acción por defecto
		if (!method_exists($this->controller, $action)) {
			$action = DEFAULT_ACTION;
		}

		// Ejecuta la acción
		return $this->controller->$action();
	}

	/**
	 * Recibe datos a reemplazar en forma de array y muestra la vista
	 * @param array $data Datos del controlador en array
	 */
	public function view($data = array()) {
		if (!empty($this->view)) {
			$this->view->setReplace($data);
			$this->view->write();
		}
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
