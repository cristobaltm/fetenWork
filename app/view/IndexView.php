<?php

class IndexView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setHtml_template("index");
	}

	function __destruct() {
		
	}

}
