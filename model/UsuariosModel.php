<?php

class UsuariosModel extends Model {

    private $table;

    public function __construct() {
        $this->table = "usuarios";
        parent::__construct($this->table);
    }

    //Metodos de consulta
    public function getUnUsuario($email) {
	$query = "SELECT * FROM usuarios WHERE email='{$email}'";
        $usuario = $this->ejecutarSql($query);
        return $usuario;
    }

}
