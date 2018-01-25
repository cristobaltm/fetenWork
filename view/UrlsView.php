<?php

require 'SiteTemplate.php';

class UrlsView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::setHtml_template("index");

		parent::add_vars_language_js(array('confirm_delete'));
		parent::add_scripts(array("urls.js"));

		parent::setReplace(array(
			'year' => date("Y"),
		));
	}

	function __destruct() {
		
	}

	public function urlTable($data) {
		$html = "";
		foreach ($data as $user) {
			$delete_url = $this->url("urls", "borrar", array($user->id_url));
			$edit_url = $this->url("urls", "edicion", array($user->id_url));
			$html .= <<<eot
	<a href="{$user->url}" target="{$user->target}">{$user->label}</a>
	<div style="float:right">
	    <a href="{$edit_url}" class="btn btn-info" title="@@lbl_edit@@"><span class="glyphicon glyphicon-edit"></span></a>
	    <a href="javascript:confirm_delete('{$delete_url}')" class="btn btn-danger" title="@@lbl_delete@@"><span class="glyphicon glyphicon-trash"></span></a>
	</div>
	<hr/>
eot;
		}
		return $html;
	}

}
