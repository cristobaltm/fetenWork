<?php

class indexView extends View {
    
    # Atributos


    # Constructor y destructor

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

    
}