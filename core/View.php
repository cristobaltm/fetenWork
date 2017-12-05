<?php

class View {

	# Atributos

	protected $html_template = "";
	protected $replace = array();

	# Constructor y destructor

	public function __construct() {
		$this->replace = array(
			'title_site' => TITLE_SITE,
			'path_web' => PATH_WEB,
			'author_name' => AUTHOR_NAME,
			'author_web' => AUTHOR_WEB
		);
	}

	function __destruct() {
		
	}

	# Setters

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
		$this->replace = array_merge($this->replace, $replace);
	}

	# Métodos

	/**
	 * Construye una URL válida con el controlador y la acción requeridas
	 * @param string $controller Nombre del controlador
	 * @param string $action Nombre de la acción
	 * @return string Dirección completa 
	 */
	public function url($controller = '', $action = '') {
		// Si el controlador está vacío, redirigimos al definido por defecto
		if (empty($controller)) {
			$controller = DEFAULT_CONTROLLER;
		}

		// Si la acción está vacía, redirigimos a la definida por defecto
		if (empty($action)) {
			$action = DEFAULT_ACTION;
		}

		// Devuelve la url formada por el index.php,
		// pasando el controlador y la acción por GET
		$url = "index.php?"
				. GET_CONTROLLER . "={$controller}&"
				. GET_ACTION . "={$action}";
		return $url;
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

		// Recorre el array de reemplazo para formatear los patrones
		$replace = array();
		foreach ($this->replace as $pattern => $value) {
			$replace["/@@{$pattern}@@/"] = (string) $value;
		}

		// Sustituye las cadenas de reemplazo dentro de la plantilla
		$html = preg_replace(
				array_keys($replace), array_values($replace), file_get_contents($this->html_template)
		);

		return $html;
	}

	/**
	 * Escribe o devuelve el HTML después de renderizarlo
	 * @param boolean $write true para escribirlo, false para que sea devuelto
	 * @return string/boolean 
	 */
	public function write($write = true) {
		$html = $this->render();

		if ($write) {
			echo $html;
			return true;
		}

		return $html;
	}

}
