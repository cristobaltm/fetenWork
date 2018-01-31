<?php

class Application {
	# Atributos

	private $controller = null;
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

		// Incluir el Controlador base
		require_once 'Controller.php';

		// Incluir el Modelo base
		require_once 'Model.php';

		// Incluir la vista Base
		require_once 'View.php';

		// Idioma por defecto
		$this->language = DEFAULT_LANG;

		// Idiomas válidos
		$this->allowed_languages = explode(',', ALLOWED_LANGUAGES);
	}

	function __destruct() {
		
	}

	# Setters

	/**
	 * Acorde a las posiciones de las variables en el array determina su función:
	 * 0 - Controlador
	 * 1 - Acción
	 * 2 en adelante - Variables pasadas por GET
	 * Si la posición 0 es el idioma, todas las posiciones corren un puesto
	 * @param array $url_var Array con las variables
	 */
	function setUrl_var($url_var) {
		// Posición inicial de las variables
		$first_num = 0;

		// Recorrer el array de variables
		foreach ($url_var as $num => $var) {

			// Si la posición 0 es un idioma válido, se define y corre la posición inicial
			if ($num == 0 && in_array($var, $this->allowed_languages)) {
				$this->language = $var;
				$this->url_var['lan'] = $var;
				$first_num++;

			// Si en primera posición no hay idioma, toma el de por defecto
			} else if ($num == 0) {
				$this->url_var['lan'] = DEFAULT_LANG;
			}

			// Si es la primera posición, es el controlador
			if ($num == $first_num) {
				$this->url_var['controller'] = $var;

				// Si es la segunda posición, es la acción
			} else if ($num == $first_num + 1) {
				$this->url_var['action'] = $var;

				// Si es una posición posterior a la segunda, es una variable GET
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
		$error = false;
		if (!is_file($strFileController)) {
			$controller = 'ErrorController';
			$strFileController = PATH_CONTROLLERS . $controller . ".php";
			$error = true;
		}

		// Incluye el fichero y carga el controlador
		require_once $strFileController;
		$this->controller = new $controller();

		// Cargar las variables URL en el controlador
		$this->controller->setUrl_var($this->url_var);

		// Carga la vista que usará el controlador
		$this->controller->loadView($name, $this->language);

		// Si se produjo error 404, mostrarlo
		if ($error) {
			$this->error404();
		}
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

		// Si no existe el método dentro del controlador, muestra error 404
		$action = $this->url_var['action'];
		if (!method_exists($this->controller, $action)) {
			$this->error404();
			$action = DEFAULT_ACTION;
		}

		// Ejecuta la acción
		return $this->controller->$action();
	}

	/**
	 *  Carga en la vista el mensaje e icono de error 404
	 */
	private function error404() {
		$this->loadController("Error");
		$this->controller->setError("@@lbl_error_404@@", "error_404.png");
	}

}
