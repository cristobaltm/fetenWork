<?php

class UsuariosController extends Controller {

    public function __construct() {
        parent::__construct();
	
	// Cargar el modelo
	require_once PATH_MODELS . 'UsuariosModel.php';
	$model	= new UsuariosModel();
        parent::setModel($model);
    }

    public function index() {	

        //Conseguimos todos los usuarios
        $allusers = $this->model->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("index", array(
            "allusers" => $allusers,
            'Hola' => 'Ejemplo microFramework MVC-POO',
            'header' => 'Ejemplo microFramework MVC-POO',
        ));
    }

    public function crear() {

        $nombre = filter_input(INPUT_POST, "nombre");
        $apellido = filter_input(INPUT_POST, "apellido");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if (!empty($nombre)) {

            //Creamos un usuario
            $this->model->setNombre($nombre);
            $this->model->setApellido($apellido);
            $this->model->setEmail($email);
            $this->model->setPassword(sha1($password));
            $this->model->save();
        }
        $this->redirect("Usuarios", "index");
    }

    public function borrar() {
        $id = (int) filter_input(INPUT_GET, "id");
        if (!empty($id)) {
            $this->model->deleteById($id);
        }
        $this->redirect();
    }

    public function hola() {
        $usu = $this->model->getUnUsuario(ADMIN_EMAIL);
        var_dump($usu);
    }

}
