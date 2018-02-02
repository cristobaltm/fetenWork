<?php

class ErrorController extends Controller {

	# Constructor y destructor

	public function __construct() {
		parent::__construct();
		$this->name = "error";
	}

	function __destruct() {
		
	}

	# Métodos

	public function main() {
		$this->view->errorSetReplace();
		$this->writeView($this->name);
	}

}
