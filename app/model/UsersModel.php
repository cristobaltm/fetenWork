<?php

class UsersModel extends Model {

	private $id;
	private $name;
	private $surname;
	private $email;
	private $password;
	private $description;

	public function __construct() {
		$table = "users";
		$id_name = "id";
		parent::__construct($table, $id_name);
	}

	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->name;
	}

	function getApellido() {
		return $this->surname;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return $this->password;
	}
	
	function getDescription() {
		return $this->description;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($name) {
		$this->name = $name;
	}

	function setApellido($surname) {
		$this->surname = $surname;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setPassword($password) {
		$this->password = $password;
	}
	
	function setDescription($description) {
		$this->description = $description;
	}

	public function save() {
		$query = "INSERT INTO users (id,name,surname,email,password, description)
VALUES(NULL, '{$this->name}', '{$this->surname}', '{$this->email}', '{$this->password}', '{$this->description}');";

		$save = $this->db()->query($query);
		//$this->db()->error;
		return $save;
	}

	//Metodos de consulta
	public function getUnUsuario($email) {
		$query = "SELECT * FROM users WHERE email='{$email}'";
		$user = $this->executeQuery($query);
		return $user;
	}

}
