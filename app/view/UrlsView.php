<?php

class UrlsView extends SiteTemplate {
	# Constructor y destructor

	public function __construct() {
		parent::__construct();

		parent::addVarsLanguageJS(array('confirm_delete'));
		parent::addScripts(array("urls.js"));

		parent::setReplace(array(
			'year' => date("Y"),
		));
	}

	function __destruct() {
		
	}

	public function urlTable($data) {
		$html = "";
		foreach ($data as $user) {
			$delete_url = $this->url("urls", "delete", array($user->id_url));
			$edit_url = $this->url("urls", "edit", array($user->id_url));
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
	
	public function formEditData($action = "") {
		$data = array(
			'label_header' => '@@lbl_add_link@@',
			'glyphicon-header' => '<span class="glyphicon glyphicon-plus"></span>',
			'input_submit' => '<input type="submit" value="@@lbl_add@@" class="btn btn-success"/>',
			'return_add' => ''
		);
		
		if($action == 'edit') {
			$data = array(
				'label_header' => '@@lbl_edit_link@@',
				'glyphicon-header' => '<span class="glyphicon glyphicon-edit"></span>',
				'input_submit' => '<input type="submit" value="@@lbl_edit@@" class="btn btn-info"/>',
				'return_add' => '<section class="return_add"><a href="@@path_site@@urls" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> @@lbl_add_link@@</a></section>'
			);
		}
		
		return $data;
	}

}
