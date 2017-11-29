<?php

class UsuariosController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //Creamos el objeto usuario
        $usuario = new Usuario();

        //Conseguimos todos los usuarios
        $allusers = $usuario->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("index", array(
            "allusers" => $allusers,
            "Hola" => "Ejemplo MVC-POO",
        ));
    }

    public function crear() {

        $nombre = filter_input(INPUT_POST, "nombre");
        $apellido = filter_input(INPUT_POST, "apellido");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if (!empty($nombre)) {

            //Creamos un usuario
            $usuario = new Usuario();
            $usuario->setNombre($nombre);
            $usuario->setApellido($apellido);
            $usuario->setEmail($email);
            $usuario->setPassword(sha1($password));
            $usuario->save();
        }
        $this->redirect("Usuarios", "index");
    }

    public function borrar() {
        $id = (int) filter_input(INPUT_POST, "id");
        if (!empty($id)) {
            $usuario = new Usuario();
            $usuario->deleteById($id);
        }
        $this->redirect();
    }

    public function hola() {
        $usuarios = new UsuariosModel();
        $usu = $usuarios->getUnUsuario(ADMIN_EMAIL);
        var_dump($usu);
    }

}
