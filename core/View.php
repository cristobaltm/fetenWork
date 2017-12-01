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
	    'author' => AUTHOR,
	    'author_web' => AUTHOR_WEB
	);
	
    }

    function __destruct() {
	
    }

    # Setters

    function setHtml_template($html_template) {
	// Define el fichero con la plantilla,
	$this->html_template  = PATH_WEB . $html_template . ".html";
	
	// y si no existe, la plantilla por defecto
	if (!is_file($this->html_template)) {
	    $this->html_template = PATH_WEB . DEFAULT_TEMPLATE . ".html";
	}
    }


    /**
     * Agrega más filas al array de reemplazo
     * @param array $replace Array con las nuevas filas
     */
    function setReplace($replace) {
	$this->replace = array_merge($this->replace, $replace);
    }

    # Métodos

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

    private function render() {
	$replace = array();
	foreach($this->replace as $pattern => $value) {
	    $replace["/@@{$pattern}@@/"] = (string) $value;
	}

	$html = preg_replace(
		array_keys($replace),
		array_values($replace),
		file_get_contents($this->html_template)
	);
	
	return $html;
    }

    public function write($write = true) {
	$html = $this->render();
	
	if($write) {
	    echo $html;
	    return true;
	}
	
	return $html;
    }

}
