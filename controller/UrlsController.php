<?php

class UrlsController extends Controller {

	public function __construct() {
		parent::__construct();
		$name = "Urls";
		parent::loadModel($name);
		parent::loadView($name);
	}

	public function listado() {
		//Conseguimos todos los usuarios
		$allurls = $this->model->getAll();
		$allurlsHTML = $this->view->urlTable($allurls);

		//Cargamos la vista index y le pasamos valores
		$this->view(array(
			"urls_table" => $allurlsHTML,
			'Hola' => 'Ejemplo microFramework MVC-POO',
			'header' => 'Ejemplo microFramework MVC-POO',
		));
	}

	public function crear() {

		$label = filter_input(INPUT_POST, "label");
		$url = filter_input(INPUT_POST, "url");
		$target = "_blank";

		if (!empty($label)) {

			//Creamos un usuario
			$this->model->setLabel($label);
			$this->model->setURL($url);
			$this->model->setTarget($target);
			$this->model->save();
		}
		$this->redirect("urls", "listado");
	}

	public function borrar() {
		$id = (int) filter_input(INPUT_GET, "id");
		if (!empty($id)) {
			$this->model->deleteById($id);
		}
		$this->redirect("urls", "listado");
	}

}
