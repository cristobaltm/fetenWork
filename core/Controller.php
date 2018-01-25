<?php

class Controller {
	# Atributos

	private $controller = null;
	protected $view = null;
	protected $model = null;
	protected $url_var = array();
	protected $language = '';
	private $allowed_languages = array();

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
		// Idiomas
		$this->language = DEFAULT_LANG;
		$this->allowed_languages = explode(',', ALLOWED_LANGUAGES);
	}

	function __destruct() {
		
	}

	# Setters

	function setController($controller) {
		$this->controller = $controller;
	}

	function setView($view) {
		$this->view = $view;
	}

	function setModel($model) {
		$this->model = $model;
	}

	function setLanguage($language) {
		$this->language = $language;
	}

	function setUrl_var($url_var) {
		$first_num = 0;
		foreach ($url_var as $num => $var) {
			if ($num == 0 && in_array($var, $this->allowed_languages)) {
				$this->language = $var;
				$this->url_var['lan'] = $var;
				$first_num++;
			} else if ($num == 0) {
				$this->url_var['lan'] = DEFAULT_LANG;
			}

			if ($num == $first_num) {
				$this->url_var['controller'] = $var;
			} else if ($num == $first_num + 1) {
				$this->url_var['action'] = $var;
			} else if ($num > $first_num + 1) {
				$this->url_var[$num - ($first_num + 1)] = $var;
			}
		}
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

		// Si no existe el fichero, carga el controlador de errores
		if (!is_file($strFileController)) {
			$controller = 'ErrorController';
			$strFileController = PATH_CONTROLLERS . $controller . ".php";
		}

		// Incluye el fichero y carga el controlador
		require_once $strFileController;
		$this->controller = new $controller();

		// Cargar las variables URL en el controlador
		$this->controller->url_var = $this->url_var;

		// Carga la vista que usará el controlador
		$this->controller->loadView($this->controller->name, $this->language);
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
	 * @param string $language Idioma
	 */
	protected function loadView($name, $language = '') {
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

		// Idioma actual
		if (empty($language) || !in_array($language, $this->allowed_languages)) {
			$language = $this->language;
		}
		$this->view->setLanguage($language);
	}

	/**
	 * Carga el controlador llamando al método loadController
	 * @param string $name Nombre del controlador
	 */
	public function load() {
		if (empty($this->url_var['controller'])) {
			$this->url_var['controller'] = DEFAULT_CONTROLLER;
		}
		$this->loadController($this->url_var['controller']);
	}

	/**
	 * Ejecuta la acción correspondiente del controlador
	 * @param string $action Nombre de la acción
	 * @return bool resultado de la acción
	 */
	public function execute() {
		if (empty($this->url_var['action'])) {
			$this->url_var['action'] = DEFAULT_ACTION;
		}

		// Si no existe el método dentro del controlador,
		// ejecuta la acción por defecto
		$action = $this->url_var['action'];
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
	public function view($data = array(), $write = true) {
		if (!empty($this->view)) {
			$this->view->setReplace($data);
			if ($write === false) {
				$html = $this->view->write($write);
				return $html;
			}
			$this->view->write();
			return true;
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
