<?php

class View {
	# Atributos

	protected $language = "";
	protected $html_template = "";
	protected $replace = array();
	protected $library = array();
	private $html_path = '';
	private $html_ext = '';

	# Constructor y destructor

	public function __construct() {
		$this->language = DEFAULT_LANG;
		$this->replace = array(
			'path_site' => PATH_SITE,
			'path_web' => PATH_SITE . PATH_WEB,
			'framework_name' => FRAMEWORK_NAME,
			'author_name' => AUTHOR_NAME,
		);
		$this->html_path = PATH_WEB . 'html/';
		$this->html_ext = '.html';
	}

	function __destruct() {
		
	}

	# Setters

	function setLanguage($language) {
		if (empty($language)) {
			$language = DEFAULT_LANG;
		}
		$this->language = $language;
	}

	function setHtml_template($html_template = '') {
		// Define el fichero con la plantilla
		$this->html_template = PATH_WEB . $html_template . ".html";

		// Si no existe el fichero, la plantilla por defecto
		if (!is_file($this->html_template)) {
			$this->html_template = PATH_WEB . DEFAULT_TEMPLATE . ".html";
		}
	}

	function setReplace($replace) {
		// En vez de sustituir el contenido, lo agrega al final
		$this->replace = array_merge($replace, $this->replace);
	}

	# Métodos

	/**
	 * Construye una URL válida con el controlador y la acción requeridas
	 * @param string $controller Nombre del controlador
	 * @param string $action Nombre de la acción
	 * @return string Dirección completa 
	 */
	public function url($controller = '', $action = '', $var_get = array()) {
		// Si el controlador está vacío, redirigimos al definido por defecto
		if (empty($controller)) {
			$controller = DEFAULT_CONTROLLER;
		}

		// Si la acción está vacía, redirigimos a la definida por defecto
		if (empty($action)) {
			$action = DEFAULT_ACTION;
		}

		// Devuelve la url formada por el controlador y la acción
		$url = PATH_SITE . $controller . '/' . $action;

		// Agregar el resto de variables GET
		foreach ($var_get as $value) {
			$url .= '/' . $value;
		}

		return $url;
	}

	/**
	 * Recorre el array de reemplazo para formatear los patrones
	 * @param array $array Array que se quiere formatear
	 * @return array Array formateado
	 */
	private function prepareReplace($array) {
		$replace = array();
		foreach ($array as $pattern => $value) {
			$replace["/". PATTERN_BEGIN . $pattern . PATTERN_END . "/"] = (string) $value;
		}
		return $replace;
	}

	/**
	 * Carga la plantilla y reemplaza las cadenas de patrones por sus valores
	 * @return string/boolean HTML con la plantilla renderizada, o false si no existe
	 */
	private function render() {
		// Si no existe el fichero con la plantilla devuelve false
		if (!is_file($this->html_template)) {
			return false;
		}

		// Formatea el array de reemplazo
		$replace = $this->prepareReplace($this->replace);

		// Sustituye las cadenas de reemplazo dentro de la plantilla
		$html = preg_replace(
				array_keys($replace), array_values($replace), file_get_contents($this->html_template)
		);

		return $this->render_language($html);
	}

	/**
	 * Traduce el texto pasado según el idioma 
	 * @param string $html Texto por traducir
	 * @return string Texto traducido
	 */
	protected function render_language($html) {
		$this->yaml_to_array();

		// Recorre el array del idioma para formatear los patrones
		$replace = array();
		foreach ($this->library as $label => $value) {
			$replace["/". PATTERN_BEGIN . "lbl_" . $label . PATTERN_END . "/"] = $value;
		}

		// Sustituye las cadenas de reemplazo dentro de la plantilla
		return preg_replace(array_keys($replace), array_values($replace), $html);
	}

	/**
	 * Escribe o devuelve el HTML después de renderizarlo
	 * @param boolean $write true para escribirlo, false para que sea devuelto
	 * @return string/boolean 
	 */
	public function write($write = true) {
		$html = $this->render();

		if ($write === true) {
			echo $html;
			return true;
		}

		return $html;
	}

	/**
	 * Carga un archivo HTML y reemplaza las cadenas de patrones por sus valores
	 * @param string $html_file 
	 * @param array $replace
	 * @return string
	 */
	public function writeHTML($html_file, $replace) {
		// Definir el archivo con su ruta, y comprobar si existe
		$file = $this->html_path . $html_file . $this->html_ext;
		if (!file_exists($file)) {
			return null;
		}

		$replace_formatted = $this->prepareReplace($replace);

		$html = preg_replace(
			array_keys($replace_formatted), array_values($replace_formatted), file_get_contents($file)
		);
		return $html;
	}

	/**
	 * Transforma el YAML con el idioma a un array
	 * @return boolean
	 */
	private function yaml_to_array() {
		require_once(PATH_VENDOR . 'spyc/spyc.php');
		$filename = PATH_CONFIG . "lan/{$this->language}.yml";

		if (!is_file($filename)) {
			return false;
		}

		$data = Spyc::YAMLLoad($filename);
		foreach ($data as $name => $value) {
			$this->library[$name] = $value;
		}
		return true;
	}

	/**
	 * Reemplaza los carácteres especiales por su equivalente en javascript
	 * @param string $string Cadena a modificar
	 * @return string Cadena modificada
	 */
	public function special_chars_javascript($string) {
		$replace = array(
			"/á/" => "\u00e1",
			"/é/" => "\u00e9",
			"/í/" => "\u00ed",
			"/ó/" => "\u00f3",
			"/ú/" => "\u00fa",
			"/Á/" => "\u00c1",
			"/É/" => "\u00c9",
			"/Í/" => "\u00cd",
			"/Ó/" => "\u00d3 ",
			"/Ú/" => "\u00da",
			"/ñ/" => "\u00f1",
			"/Ñ/" => "\u00d1",
			"/¿/" => "\u00BF",
			"/\'/" => "\u00b7",
			"/\"/" => "\u0022",
		);

		return preg_replace(array_keys($replace), array_values($replace), $string);
	}

}
