<?php

class Template extends View {
    
    # Constructor y destructor

    /**
     *  Plantilla base
     */
    public function __construct() {
	parent::__construct();
	
	parent::setHtml_template("index");
	
	parent::setReplace( array(
	    'title_site' => TITLE_SITE,	    
	    'year' => date("Y"),
	    'form_action' => $this->url("usuarios", "crear"),
	    'users_table' => '',	
	));
    }

    function __destruct() {
	
    }
    
    # Métodos
    
    
}
