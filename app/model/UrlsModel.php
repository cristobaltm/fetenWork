<?php

class UrlsModel extends Model {

	private $id_url;
	private $label;
	private $url;
	private $target;

	public function __construct() {
		$table = "urls";
		$id_name = "id_url";
		parent::__construct($table, $id_name);
	}

	public function __destruct() {
		parent::__destruct();
	}

	function getId_url() {
		return $this->id_url;
	}

	function getLabel() {
		return $this->label;
	}

	function getUrl() {
		return $this->url;
	}

	function getTarget() {
		return $this->target;
	}

	function setId_url($id_url) {
		$this->id_url = $id_url;
	}

	function setLabel($label) {
		$this->label = $label;
	}

	function setUrl($url) {
		$this->url = $url;
	}

	function setTarget($target) {
		$this->target = $target;
	}

	public function save() {
		$query = "INSERT INTO urls (id_url, label, url, target, registrationDate, removed) 
VALUES (NULL, '{$this->label}', '{$this->url}', '{$this->target}', NOW(), 0);";

		$save = $this->db()->query($query);
		return $save;
	}

	public function edit($field, $value, $id) {
		$query = "UPDATE {$this->table} SET {$field} = '{$value}' WHERE id_url = {$id}";
		die($query);

		$edit = $this->db()->query($query);
		return $edit;
	}

}
