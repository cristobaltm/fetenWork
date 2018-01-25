<?php

require 'SiteTemplate.php';

class ErrorView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setHtml_template("index");

		parent::setReplace(array(
			'content' => "@@lbl_error_wrong_page@@",
		));
	}

	function __destruct() {
		
	}

}
