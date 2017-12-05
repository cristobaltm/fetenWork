<?php

class UsuariosView extends View {

	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setHtml_template("index");

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
			$delete_url = $this->url("usuarios", "borrar");
			$html .= <<<eot
	{$user->id} - {$user->nombre} - {$user->apellido} - {$user->email}
	<div class="right">
	    <a href="{$delete_url}&id={$user->id}" class="btn btn-danger">Borrar</a>
	</div>
	<hr/>
eot;
		}
		return $html;
	}

}
