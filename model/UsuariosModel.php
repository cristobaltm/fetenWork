<?php

class UsuariosModel extends Model {

	private $id;
	private $nombre;
	private $apellido;
	private $email;
	private $password;

	public function __construct() {
		$table = "usuarios";
		$id_name = "id";
		parent::__construct($table, $id_name);
	}

	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getApellido() {
		return $this->apellido;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return $this->password;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	function setApellido($apellido) {
		$this->apellido = $apellido;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setPassword($password) {
		$this->password = $password;
	}

	public function save() {
		$query = "INSERT INTO usuarios (id,nombre,apellido,email,password)
VALUES(NULL, '{$this->nombre}', '{$this->apellido}', '{$this->email}', '{$this->password}');";

		$save = $this->db()->query($query);
		//$this->db()->error;
		return $save;
	}

	//Metodos de consulta
	public function getUnUsuario($email) {
		$query = "SELECT * FROM usuarios WHERE email='{$email}'";
		$usuario = $this->executeQuery($query);
		return $usuario;
	}

}
