<?php

class UsuariosController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->name = "usuarios";
		parent::loadModel($this->name);
	}

	public function listado() {
		//Conseguimos todos los usuarios
		$allusers = $this->model->getAll();
		$allusersHTML = $this->view->userTable($allusers);

		return $allusersHTML;
	}

	public function main() {
		$this->view->setPage($this->name);
		$this->view->getMenu();
		$this->view(array(
			'content' => $this->getContent('usuarios'),
			'form_action' => $this->view->url("usuarios", "crear"),
		));
	}

	private function getContent($html) {
		require_once ('core/resources/Template.php');
		$template = new Template();

		$replace = array(
			'users_table' => $this->listado()
		);
		return $template->get_html($html, $replace);
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
		$this->redirect("usuarios", "main");
	}

	public function borrar() {
		$id = (int) $this->url_var[1];
		if (!empty($id)) {
			$this->model->deleteById($id);
		}
		$this->redirect("usuarios", "main");
	}

}
