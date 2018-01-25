<?php

class IndexController extends Controller {

	protected $name = "";

	public function __construct() {
		parent::__construct();
		$this->name = "index";
	}

	public function main() {
		$this->view->setPage($this->name);
		$this->view->getMenu();
		$this->view(array(
			'content' => $this->getContent(),
		));
	}

	private function getRandom($low = true) {
		if ($low === true) {
			return rand(1, 99);
		}
		return rand(100, 999);
	}

	private function getContent() {
		require_once ('core/resources/Template.php');
		$template = new Template();

		$replace = array(
			'random_1' => $this->getRandom(false),
			'random_2' => $this->getRandom(),
			'random_3' => $this->getRandom(false),
			'random_4' => $this->getRandom(),
			'random_5' => $this->getRandom(false),
			'random_6' => $this->getRandom(),
		);
		return $template->get_html('example', $replace);
	}

}
