<?php

class DBConnection {

	private $table;
	private $id_name;
	private $db;
	private $driver, $host, $user, $pass, $database, $charset;

	public function __construct($table, $id_name) {
		$this->table = (string) $table;
		$this->id_name = (string) $id_name;

		$db_cfg = require_once 'config/database.php';
		$this->driver = $db_cfg["driver"];
		$this->host = $db_cfg["host"];
		$this->user = $db_cfg["user"];
		$this->pass = $db_cfg["pass"];
		$this->database = $db_cfg["database"];
		$this->charset = $db_cfg["charset"];
		$this->db = $this->connection();
	}

	public function db() {
		return $this->db;
	}

	private function connection() {
		if ($this->driver == "mysql" || $this->driver == null) {
			$con = new mysqli($this->host, $this->user, $this->pass, $this->database);
			$con->query("SET NAMES '{$this->charset}'");
			return $con;
		}

		return false;
	}

	public function getAll() {
		$resultSet = array();
		$query = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$this->id_name} DESC");

		//Devolvemos el resultset en forma de array de objetos
		while ($row = $query->fetch_object()) {
			$resultSet[] = $row;
		}

		return $resultSet;
	}

	public function getById($id) {
		$query = $this->db->query("SELECT * FROM {$this->table} WHERE {$this->id_name} = {$id}");

		$row = $query->fetch_object();
		if ($row) {
			return $row;
		}

		return false;
	}

	public function getBy($column, $value) {
		$resultSet = array();
		$query = $this->db->query("SELECT * FROM {$this->table} WHERE {$column} = '{$value}'");

		while ($row = $query->fetch_object()) {
			$resultSet[] = $row;
		}

		return $resultSet;
	}

	public function deleteById($id) {
		$query = $this->db->query("DELETE FROM {$this->table} WHERE {$this->id_name} = {$id}");
		return $query;
	}

	public function deleteBy($column, $value) {
		$query = $this->db->query("DELETE FROM {$this->table} WHERE {$column} = '{$value}'");
		return $query;
	}

	public function updateById($id, $field, $value) {
		$sql = "UPDATE {$this->table} SET {$field} = '{$value}' WHERE {$this->id_name} = {$id}";
		$query = $this->db->query($sql);
		return $query;
	}

	/*
	 * Aquí podemos montarnos un montón de métodos que nos ayuden
	 * a hacer operaciones con la base de datos de la entidad
	 */
}
