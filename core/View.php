<?php

class View {

    public function url($controller = '', $action = '') {	
	if (empty($controller)) {
	    $controller = DEFAULT_CONTROLLER;
	}	
	if (empty($action)) {
	    $action = DEFAULT_ACTION;
	}
        
	$urlString = "index.php?controller={$controller}&action={$action}";
        return $urlString;
    }

    //Helpers para las vistas
}
