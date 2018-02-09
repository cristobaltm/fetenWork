<?php

class ErrorView extends SiteTemplate {
	# Atributos
	private $message = "";
	private $icon = "";	
	private $return = false;
	 
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		$this->message = "@@lbl_error_default@@";
		$this->icon = PATH_SITE . PATH_WEB . "img/error.png";
	}

	function __destruct() {
		
	}

	# Setters
	function setMessage($message) {
		$this->message = $message;
	}

	function setIcon($icon) {
		$file = PATH_WEB . "img/" . $icon;
		if(is_file($file)) {
			$this->icon = PATH_SITE . PATH_WEB . "img/" . $icon;
		} else {
			$this->icon = PATH_SITE . PATH_WEB . "img/error.png";
		}
	}
	
	function setReturn($return) {
		$this->return = $return;
	}
		
	# M�todos
	public function errorSetReplace() {

		parent::setReplace(array(
			'content' => $this->content()
		));		
	}
		
	private function content() {
		// Si return es true, mostrar el bot�n de retorno
		$bt_return = "";
		if ($this->return) {
			$bt_return = '<div><button type="button" class="btn btn-primary btn-sm" onclick="history.back()"><span class="glyphicon glyphicon-backward"></span> @@lbl_back@@</button></div>';
		}
		
		// Devolver el mensaje de error con el icono
		$html = <<<eot
<section class="content header_radius">

    <div class="errorInfo">
		<img class="icon" src="{$this->icon}">
		<h2><span class="fa fa-exclamation-triangle"></span> {$this->message}</h2>
    </div>
{$bt_return}
</section>
eot;
		return $html;
	}

}
