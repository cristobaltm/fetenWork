<?php

class UrlsView extends View {
    
    # Constructor y destructor

    public function __construct() {
	parent::__construct();
	
	parent::setHtml_template("urls");
	
	parent::setReplace( array(    
			'year' => date("Y"),
			'form_action' => $this->url("urls", "crear"),	
		));
    }

    function __destruct() {
	
    }

    public function urlTable($data) {
        $html = "";
	foreach($data as $user) {
	    $delete_url = $this->url("urls", "borrar");
	    $html .= <<<eot
	<a href="{$user->url}" target="{$user->target}">{$user->label}</a>
	<div class="right">
	    <a href="{$delete_url}&id={$user->id_url}" class="btn btn-danger">Borrar</a>
	</div>
	<hr/>
eot;
	}
	return $html;
    }
}