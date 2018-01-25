<?php

/**
 * Construye el menú lateral
 */
class Menu {

	private $file = "";
	private $menu = "";
	private $method = "";
	private $cont_sub_menu = 0;

	function __construct() {
		$this->file = "config/menu.csv";
		$this->method = "csv";
	}

	function __destruct() {
		
	}

	/**
	 * Crea el menú en html a partir del array $this->menu
	 * @param string $active Página activa, para que se muestre destacada
	 * @return string HTML con el menú en forma de listado
	 */
	public function write($active = "") {
		if ($this->method === "csv") {
			$this->csv_to_menu();
		}

		if (empty($this->menu)) {
			return null;
		}

		$html = "\n\t<ul class=\"nav\">";

		foreach ($this->menu as $num => $data) {
			if($num !== 'Header') {
				$html .= "\n\t\t" . $this->write_li($data, $num, $this->li_class($data, $num, $active));				
			}
		}
		$html .= "\n\t</ul>";
		return $html;
	}
	
	private function li_class($data, $num, $active) {
		$return = array('class' => '', 'submenu_fixed' => false);
		if (isset($data['label']) && $data['label'] === $active) {
			$return['class'] = 'class="active"';
		}
		
		$i = $num + 1;
		while(isset($this->menu[$i]['level']) && $this->menu[$i]['level'] == 2) {
			if($this->menu[$i]['url'] === $active) {
				$return['submenu_fixed'] = true;
			}
			$i++;
		}
		return $return;		
	}

	private function write_li($data, $num, $li_class) {
		if($data['level'] == 1 && isset($this->menu[$num + 1]) && $this->menu[$num + 1]['level'] == 2) {
			$this->cont_sub_menu++;
			$html = <<<eot
<li class="submenu">
			<input id="ac-{$this->cont_sub_menu}" name="accordion-{$this->cont_sub_menu}" type="checkbox">
			<label for="ac-{$this->cont_sub_menu}">@@lbl_{$data['label']}@@<span class="desplegable">+</span></label> 
			<article id="ac-article-{$this->cont_sub_menu}" class="ac-small">
				<ul>
eot;
			if($li_class['submenu_fixed'] === true) {
				$html = <<<eot
<li class="submenu">
			<span id="submenu_fixed">@@lbl_{$data['label']}@@</span>
			<article class="ac-small" style="height: auto;">
				<ul>
eot;
			}
			
		} else {
			$url = $data['url'];
			if( $data['type'] === 'internal') {
				$url = PATH_SITE . $data['url'];
			}
			$html = "<li><a href=\"{$url}\" {$li_class['class']} target=\"{$data['target']}\"><span>@@lbl_{$data['label']}@@</span></a></li>";
		}
		
		if($data['level'] == 2 && (!isset($this->menu[$num + 1]) || $this->menu[$num + 1]['level'] == 1)) {
			$html .= <<<eot

				</ul>
			</article>
		  </li>
eot;
		}
		
		return $html;
	}

	private function csv_to_menu() {
		require_once ('Csv_to_array.php');
		$csv = new Csv_to_array($this->file, ';');
		$csv->initialize();
		$csv->remove_header();
		$this->menu = $csv->get_data();
	}

}
