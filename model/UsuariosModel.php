<?php

class UsuariosModel extends Model {


    public function __construct() {
        $table = "usuario";
        $id_name = "id";
        parent::__construct($table, $id_name);
    }

    //Metodos de consulta
    public function getUnUsuario($email) {
	$query = "SELECT * FROM usuarios WHERE email='{$email}'";
        $usuario = $this->ejecutarSql($query);
        return $usuario;
    }

}
