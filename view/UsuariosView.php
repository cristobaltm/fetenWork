<?php

require 'SiteTemplate.php';

class UsuariosView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();
		parent::setHtml_template("index");

		parent::add_vars_language_js(array('confirm_delete'));
		parent::add_scripts(array("urls.js"));
		
		parent::setReplace(array(
			'year' => date("Y"),
			'form_action' => $this->url("usuarios", "crear"),
		));
	}

	function __destruct() {
		
	}

	public function userTable($data) {
		$html = "";
		foreach ($data as $user) {
			$delete_url = $this->url("usuarios", "borrar", array($user->id));
			$html .= <<<eot
	{$user->id} - {$user->nombre} - {$user->apellido} - {$user->email}
	<div style="float:right">
	    <a href="javascript:confirm_delete('{$delete_url}')" class="btn btn-danger" title="@@lbl_delete@@"><span class="glyphicon glyphicon-trash"></span></a>
	</div>
	<hr/>
eot;
		}
		return $html;
	}

}
