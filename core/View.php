<?php

class View {
    
    # Atributos

    protected $html_template = "";
    protected $replace = array();

    # Constructor y destructor

    public function __construct() {
	
    }

    function __destruct() {
	
    }

    # Setters

    function setHtml_template($html_template) {
	$this->html_template = $html_template;
    }

    function setReplace($replace) {
	$this->replace = $replace;
    }

    # Métodos

    /**
     * Agrega más filas al array de reemplazo
     * @param array $replace Array con las nuevas filas
     */
    public function mergeReplace($replace) {
	return array_merge($this->replace, $replace);
    }

    /**
     * Construye una URL válida con el controlador y la acción requeridas
     * @param string $controller
     * @param string $action
     * @return string
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

    public function render() {
	$html = preg_replace(
		array_keys($this->replace), array_values($this->replace), $this->html_template
	);
	return $html;
    }

}
