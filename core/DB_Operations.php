<?php

class DB_Operations  {

    private $table;
    private $db;
    private $con;

    public function __construct($table) {
        $this->table = (string) $table;

        require_once 'DB_Connect.php';
        $this->con = new DB_Connect();
        $this->db = $this->con->connection();
    }

    public function getCon() {
        return $this->con;
    }

    public function db() {
        return $this->db;
    }

    public function getAll() {
        $resultSet = array();
        $query = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");

        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }

    public function getById($id) {
        $query = $this->db->query("SELECT * FROM {$this->table} WHERE id = {$id}");

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
        $query = $this->db->query("DELETE FROM {$this->table} WHERE id = {$id}");
        return $query;
    }

    public function deleteBy($column, $value) {
        $query = $this->db->query("DELETE FROM {$this->table} WHERE {$column} = '{$value}'");
        return $query;
    }

    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
}
