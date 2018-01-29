<?php

class Template {

	private $template = '';
	private $path = '';
	private $ext = '';
	private $html = '';
	private $replace = array();

	function __construct() {
		$this->path = 'web/html/';
		$this->ext = '.html';
	}

	function __destruct() {
		
	}

	function get_template_value() {
		return $this->template;
	}

	function get_html_value() {
		return $this->html;
	}

	function get_replace_value() {
		return $this->replace;
	}

	public function set_path($path) {
		$this->path = $path;
	}

	private function set_template($template) {
		$file = $this->path . $template . $this->ext;
		if (file_exists($file)) {
			$this->template = $file;
			return true;
		}
		return false;
	}

	private function set_libray($template) {
		$file = $this->path . $template . '.php';
		if (file_exists($file)) {
			$this->template = $file;
			return true;
		}
		return false;
	}

	private function set_replace($replace) {
		if (is_array($replace)) {
			$this->replace = array();
			foreach ($replace as $field => $value) {
				$this->replace['/@@' . $field . '@@/'] = $value;
			}

			return true;
		}
		return false;
	}

	public function get_html($template, $replace = array()) {
		if ($this->set_template($template) && $this->set_replace($replace)) {
			$this->html = preg_replace(
					array_keys($this->replace), array_values($this->replace), file_get_contents($this->template)
			);
			return $this->html;
		}
		return null;
	}

	public function get_element($label, $replace = array(), $library = 'lib_elements') {
		if ($this->set_libray($library) && $this->set_replace($replace)) {
			include $this->template;
			if (isset($LIB_ELEMENT) && isset($LIB_ELEMENT[$label])) {
				$this->html = preg_replace(
						array_keys($this->replace), array_values($this->replace), $LIB_ELEMENT[$label]
				);
				return $this->html;
			}
		}
		return null;
	}

	public function get_input_hidden($name, $value) {
		return $this->get_element('input_hidden', array(
			'name' => $name,
			'value' => $value
		));
	}

	public function get_redirect_form($action, $inputs, $method = 'POST') {
		return $this->get_html('form_return', array(
			'action' => $action,
			'method' => $method,
			'inputs' => $inputs
		));
	}

}
