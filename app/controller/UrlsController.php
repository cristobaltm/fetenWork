<?php

class UrlsController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->name = "urls";
		parent::loadModel($this->name);
	}

	public function showList() {
		//Conseguimos todos los usuarios
		$allurls = $this->model->getAll();
		return $this->view->urlTable($allurls);
	}

	public function main() {
		$for_data = $this->view->formEditData("add");
		$this->writeView($this->name, array(
			'content' => $this->getContent('urls'),
			'form_action' => $this->view->url("urls", "insert"),
			'id_val' => 0,
			'etiqueta_val' => '',
			'direccion_val' => '',
			'label_header' => $for_data['label_header'],
			'glyphicon-header' => $for_data['glyphicon-header'],
			'input_submit' => $for_data['input_submit'],
			'return_add' => $for_data['return_add'],
		));
	}

	private function getContent($html) {
		$replace = array(
			'urls_table' => $this->showList()
		);
		return $this->view->writeHTML($html, $replace);
	}

	public function edit() {
		if (empty($this->url_var[1])) {
			$this->redirect("urls");
			return false;
		}
		$data = $this->model->getById($this->url_var[1]);
		if (!isset($data->removed) || $data->removed === 1) {
			$this->redirect("urls");
			return false;
		}

		$for_data = $this->view->formEditData("edit");
		$this->writeView($this->name, array(
			'content' => $this->getContent('urls'),
			'form_action' => $this->view->url("urls", "update"),
			'id_val' => $data->id_url,
			'etiqueta_val' => $data->label,
			'direccion_val' => $data->url,
			'label_header' => $for_data['label_header'],
			'glyphicon-header' => $for_data['glyphicon-header'],
			'input_submit' => $for_data['input_submit'],
			'return_add' => $for_data['return_add'],
		));
		return true;
	}

	public function insert() {

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
		$this->redirect("urls");
	}

	public function update() {

		$id = filter_input(INPUT_POST, "id");
		$label = filter_input(INPUT_POST, "label");
		$url = filter_input(INPUT_POST, "url");

		if (!empty($label)) {
			$this->model->updateField($id, 'label', $label);
			$this->model->updateField($id, 'url', $url);
		}
		$this->redirect("urls");
	}

	public function delete() {
		$id = (int) $this->url_var[1];
		if (!empty($id)) {
			$this->model->remove($id);
		}
		$this->redirect("urls");
	}

}
