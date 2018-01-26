<?php

require 'SiteTemplate.php';

class ErrorView extends SiteTemplate {
	# Atributos
	private $message = "";
	private $icon = "";	
	 
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setHtml_template("index");
		
		$this->message = "@@lbl_error_default@@";
		$this->icon = "@@path_web@@img/error.png";
	}

	function __destruct() {
		
	}

	# Setters
	function setMessage($message) {
		$this->message = $message;
	}

	function setIcon($icon) {
		$this->icon = "@@path_web@@img/" . $icon;
	}
		
	public function errorSetReplace() {

		parent::setReplace(array(
			'content' => $this->getContent()
		));		
	}
		
	private function getContent() {
		$html = <<<eot
<section class="content">

    <div class="errorInfo">
		<img class="icon" src="{$this->icon}">
		<h2><span class="fa fa-exclamation-triangle"></span> {$this->message}</h2>
    </div>

</section>
eot;
		return $html;
	}

}
