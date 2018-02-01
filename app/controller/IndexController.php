<?php

class IndexController extends Controller {

	protected $name = "";

	public function __construct() {
		parent::__construct();
		$this->name = "index";
	}

	public function main() {
		$this->writeView($this->name, array(
			'content' => $this->getContent(),
		));
	}

	private function getRandom($day = true) {
		if ($day === true) {
			return rand(1, 31);
		}
		$month = rand(1, 12) . "/" . date("Y");
		return $month;
	}

	private function getContent() {
		$replace = array(
			'random_1' => $this->getRandom(),
			'random_2' => $this->getRandom(false),
			'random_3' => $this->getRandom(),
			'random_4' => $this->getRandom(false),
			'random_5' => $this->getRandom(),
			'random_6' => $this->getRandom(false),
		);		
		return $this->view->writeHTML('example', $replace);
	}

}
