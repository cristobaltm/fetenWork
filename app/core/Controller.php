<?php

/**
 *  Controlador base
 */
class Controller {
	# Atributos

	protected $name = null;
	public $view = null;
	public $model = null;
	protected $url_var = array();
	protected $language = '';
	private $allowed_languages = array();

	# Constructor y destructor

	public function __construct() {

		// Idioma por defecto
		$this->language = DEFAULT_LANG;

		// Idiomas válidos
		$this->allowed_languages = explode(',', ALLOWED_LANGUAGES);
	}

	function __destruct() {
		
	}

	# Setters

	function setLanguage($language) {
		$this->language = $language;
	}

	function setUrl_var($url_var) {
		$this->url_var = $url_var;
	}

	# Métodos

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
	public function loadView($name, $language = '') {
		// Define la vista y la ruta del fichero
		$view = ucwords($name) . 'View';
		$strFileView = PATH_VIEWS . $view . ".php";

		// Si no existe el fichero, carga la vista por defecto
		if (!is_file($strFileView)) {
			$view = DEFAULT_CONTROLLER . 'View';
			$strFileView = PATH_VIEWS . $view . ".php";
		}

		// Incluye el fichero y carga la vista
		require_once PATH_VIEWS . 'SiteTemplate.php';
		require_once $strFileView;
		$this->view = new $view();

		// Idioma actual
		if (empty($language) || !in_array($language, $this->allowed_languages)) {
			$language = $this->language;
		}
		$this->view->setLanguage($language);
	}

	/**
	 * Recibe datos a reemplazar en forma de array y muestra la vista
	 * @param string $name Nombre de la sección a cargar
	 * @param array $data Datos que reemplazar en el texto
	 * @param boolean $write true: escribe el código / false: devuelve el código
	 * @return boolean/string Devuelve true si muestra el código,
	 *  false si no existe la vista, o el código si el parámetro $write es false
	 */
	public function writeView($name = "", $data = array(), $write = true) {
		// Si la vista no está cargada devuelve false
		if (empty($this->view)) {
			return false;
		}

		// Si el nombre está vacío, se toma el del controlador
		if (empty($name)) {
			$name = $this->name;
		}

		// Escribe el menú, pasando el nombre para que quede marcado
		$this->view->getMenu($name);

		// Se pasa a la vista el array con los datos a reemplazar en el texto
		$this->view->setReplace($data);

		// Si no se debe escribir la vista, la devuelve en un string
		if ($write === false) {
			$html = (string) $this->view->write($write);
			return $html;
		}

		// Escribir la vista y devolver true
		$this->view->write();
		return true;
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

	/**
	 * Carga en el controlador Error el mensaje y el icono
	 * @param string $message Mensaje de error
	 * @param string $icon Icono del error
	 */
	public function setError($message = "", $icon = "") {
		if ($this->name == "error") {
			$this->view->setMessage($message);
			if (!empty($icon)) {
				$this->view->setIcon($icon);
			}
		}
	}

}
