<?php

class SiteTemplate extends View {

	private $page = "";

	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setReplace(array(
			'year' => date("Y"),
			'group_web' => GROUP_WEB,
			'scripts' => '',
		));
	}

	function __destruct() {
		
	}

	# Setter

	function setPage($page) {
		$this->page = $page;
	}

	# Métodos

	public function getMenu() {
		require_once ('core/resources/Menu.php');
		$menu = new Menu();
		$this->setReplace(array(
			'nav_ul' => $menu->write($this->page),
		));
		return true;
	}

	public function add_vars_language_js($vars = array()) {
		if (count($vars) == 0) {
			return false;
		}
		$js = "\n\t\t<script>";
		foreach ($vars as $file) {
			$js .= "\n\t\t\t var lbl_{$file} = '@@lbl_{$file}@@';";
		}
		$js .= "\n\t\t</script>";
		$this->replace['scripts'] .= $js;
		return true;
	}

	public function add_scripts($files = array()) {
		foreach ($files as $file) {
			$this->replace['scripts'] .= "\n\t\t<script src=\"@@path_web@@js/{$file}\"></script>";
		}
		return true;
	}

}
