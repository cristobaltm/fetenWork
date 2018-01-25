<?php

class ErrorController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->name = "error";
	}

	public function main() {
		$this->view->setPage($this->name);
		$this->view->getMenu();
		$this->view();
	}

}
