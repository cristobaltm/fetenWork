<?php

class SiteTemplate extends View {

	private $page = "";

	# Constructor y destructor

	public function __construct() {
		parent::__construct();
		parent::setHtml_template();

		parent::setReplace(array(
			'year' => date("Y"),
			'group_web' => GROUP_WEB,
			'scripts' => '',
			'url_1' => PATH_SITE . URL_1,
			'url_2' => PATH_SITE . URL_2,
			'url_3' => PATH_SITE . URL_3,
			'url_politic' => PATH_SITE . URL_POLITIC,
			'url_facebook' => URL_FACEBOOK,
			'url_twitter' => URL_TWITTER,
			'url_instagram' => URL_INSTAGRAM,
		));
	}

	function __destruct() {
		
	}

	# Setter

	function setPage($page) {
		$this->page = $page;
	}

	# Métodos

	public function getMenu($page = '') {
		if(!empty($page)) {
			$this->setPage($page);
		}
		require_once (PATH_RESOURCES . 'Menu.php');
		$menu = new Menu();
		$this->setReplace(array(
			'nav_ul' => $menu->writeMenu($this->page),
		));
		return true;
	}

	public function addVarsLanguageJS($vars = array()) {
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

	public function addScripts($files = array()) {
		foreach ($files as $file) {
			$this->replace['scripts'] .= "\n\t\t<script src=\"@@path_web@@js/{$file}\"></script>";
		}
		return true;
	}

}
