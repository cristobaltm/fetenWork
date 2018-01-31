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
		$this->file = PATH_CONFIG . "menu.csv";
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
			if ($num !== 'Header') {
				$html .= "\n\t\t" . $this->write_li($data, $num, $this->li_class($data, $num, $active));
			}
		}
		$html .= "\n\t</ul>";
		return $html;
	}

	/**
	 * Determina si hay que remarcar la línea, al ser la activa,
	 * o es la cabecera de un submenú que contiene una línea activa
	 * @param array $data
	 * @param int $num Número de línea
	 * @param string $active Línea activa del menú, que hay que remarcar
	 * @return array 'class': Clase de la línea, 'submenu_fixed': booleano si es un submenú fijo
	 */
	private function li_class($data, $num, $active) {
		$return = array('class' => '', 'submenu_fixed' => false);
		if (isset($data['label']) && $data['label'] === $active) {
			$return['class'] = 'class="active"';
		}

		$i = $num + 1;
		while (isset($this->menu[$i]['level']) && $this->menu[$i]['level'] == 2) {
			if ($this->menu[$i]['label'] === $active) {
				$return['submenu_fixed'] = true;
			}
			$i++;
		}
		return $return;
	}

	/**
	 * Escribe en HTML la línea de menú, en función de los parámetros 
	 * @param array $data Datos de la línea
	 * @param int $num Número de línea
	 * @param array $li_class Información sobre el estilo
	 * @return string Cadena HTML con la línea
	 */
	private function write_li($data, $num, $li_class) {
		// Si es la cabecera de un submenú
		if ($data['level'] == 1 && isset($this->menu[$num + 1]) && $this->menu[$num + 1]['level'] == 2) {
			$this->cont_sub_menu++;
			$html = $this->html_head_submenu($data, $li_class);

			// Si es una línea simple
		} else {
			$html = $this->html_li_simple($data, $li_class);
		}

		// Si es el final de un submenú
		if ($data['level'] == 2 && (!isset($this->menu[$num + 1]['level']) || $this->menu[$num + 1]['level'] == 1)) {
			$html .= <<<eot

				</ul>
			</article>
		  </li>
eot;
		}

		return $html;
	}

	/**
	 * Escribe en HTML una cabecera de submenú
	 * @param array $data Datos de la línea
	 * @param array $li_class Información sobre el estilo
	 * @return string Cadena HTML con la cabecera
	 */
	private function html_head_submenu($data, $li_class) {
		$html = <<<eot
<li class="submenu">
			<input id="ac-{$this->cont_sub_menu}" name="accordion-{$this->cont_sub_menu}" type="checkbox">
			<label for="ac-{$this->cont_sub_menu}">@@lbl_{$data['label']}@@<span class="desplegable">+</span></label> 
			<article id="ac-article-{$this->cont_sub_menu}" class="ac-small">
				<ul>
eot;
		// Si dentro del submenú está la opción activa, la cabecera será fija
		if ($li_class['submenu_fixed'] === true) {
			$html = <<<eot
<li class="submenu">
			<label id="submenu_fixed">@@lbl_{$data['label']}@@ <span class="desplegable fa fa-angle-down"></span></label>
			<article class="ac-small" style="height: auto;">
				<ul>
eot;
		}
		return $html;
	}

	/**
	 * Escribe en HTML una línea simple de menú
	 * @param array $data Datos de la línea
	 * @param array $li_class Información sobre el estilo
	 * @return string Cadena HTML con la línea
	 */
	private function html_li_simple($data, $li_class) {
		$url = $data['url'];
		if ($data['type'] === 'internal') {
			$url = PATH_SITE . $data['url'];
		}
		
		// Si es un enlace externo, agregar icono al inicio
		$icon = '';
		if($data['target'] == '_blank') {
			$icon = ' &nbsp;<span class="fa fa-external-link"></span>';
		}
		
		$html = "<li><a href=\"{$url}\" {$li_class['class']} target=\"{$data['target']}\">@@lbl_{$data['label']}@@{$icon}</a></li>";
		return $html;
	}

	/**
	 * Toma un archivo externo CSV y lo transforma en un array menu
	 */
	private function csv_to_menu() {
		require_once ('Csv_to_array.php');
		$csv = new Csv_to_array($this->file, ';');
		$csv->initialize();
		$csv->remove_header();
		$this->menu = $csv->get_data();
	}

}
