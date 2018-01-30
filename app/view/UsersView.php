<?php

class UsersView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();
		parent::setHtml_template("index");

		parent::addVarsLanguageJS(array('confirm_delete'));
		parent::addScripts(array("urls.js"));
		
		parent::setReplace(array(
			'year' => date("Y"),
			'form_action' => $this->url("users", "insert"),
		));
	}

	function __destruct() {
		
	}

	public function userTable($data) {
		$html = "";
		foreach ($data as $user) {
			$delete_url = $this->url("users", "delete", array($user->id));
			$html .= <<<eot
	{$user->id} - {$user->name} - {$user->surname} - {$user->email}
	<div style="float:right">
	    <a href="javascript:confirm_delete('{$delete_url}')" class="btn btn-danger" title="@@lbl_delete@@"><span class="glyphicon glyphicon-trash"></span></a>
	</div>
	<hr/>
eot;
		}
		return $html;
	}

}
