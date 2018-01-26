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

	private function getRandom($day = true) {
		if ($day === true) {
			return rand(1, 31);
		}
		$month = rand(1, 12) . "/" . date("Y");
		return $month;
	}

	private function getContent() {
		require_once ('core/resources/Template.php');
		$template = new Template();

		$replace = array(
			'random_1' => $this->getRandom(),
			'random_2' => $this->getRandom(false),
			'random_3' => $this->getRandom(),
			'random_4' => $this->getRandom(false),
			'random_5' => $this->getRandom(),
			'random_6' => $this->getRandom(false),
		);
		return $template->get_html('example', $replace);
	}

}
