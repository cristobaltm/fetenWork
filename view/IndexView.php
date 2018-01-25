<?php

require 'SiteTemplate.php';

class IndexView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setHtml_template("index");
		parent::setReplace(array(
			'url_facebook' => URL_FACEBOOK,
			'url_twitter' => URL_TWITTER,
			'url_instagram' => URL_INSTAGRAM,
		));
	}

	function __destruct() {
		
	}

}
