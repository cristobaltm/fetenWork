<?php

class ErrorController extends Controller {

	# Constructor y destructor

	public function __construct() {
		parent::__construct();
		$this->name = "error";
	}

	function __destruct() {
		
	}

	# M�todos

	public function main() {
		$this->view->errorSetReplace();
		$this->writeView($this->name);
	}

}
