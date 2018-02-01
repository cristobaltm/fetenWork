<?php

class PoliticController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->name = "politic";
	}

	public function main() {
		$this->writeView($this->name, array(
			'content' => $this->view->writeHTML("politic")
		));
	}

}
