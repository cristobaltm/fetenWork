<?php

class Csv_to_array {

    private $file = "";
    private $delimiter = ",";
    private $included_fields = array();
    private $data = array();

    function __construct($file, $delimiter = ",") {
		$this->file = $file;
		$this->delimiter = $delimiter;
    }

    function __destruct() {
	
    }

    /**
     * Devuelve el array con la información del CSV (si se ha inicializado con la función initialize
     * @return array
     */
    public function get_data() {
		return $this->data;
    }

    /**
     * Agrega campos al array de los que se incluiran
     * Campos disponibles: "ExecutionId","CycleName","Issue Key","Test Summary","Labels","Project","Component","Version","Priority","Assigned To","Executed By","Executed On","ExecutionStatus","Comment","ExecutionDefects","CreationDate","StepId","OrderId","Step","Test Data","Expected Result","Step Result","Comments"
     * @param mixed $included_fields Si es array se une a lo existente, si es otro tipo se agrega al final
     */
    public function push_included_fields($included_fields) {
		if (is_array($included_fields)) {
			$this->included_fields = array_merge($this->included_fields, $included_fields);
		} else {
			array_push($this->included_fields, $included_fields);
		}
	}

    private function initialize_with_head_first($array_map, $rename_num_field = false) {
		$head = $array_map[0];
		unset($array_map[0]);

		$header = array('Header' => array());

		foreach($head as $field) {
			if (empty($this->included_fields) || in_array($field, $this->included_fields)) {
				array_push($header['Header'],$field);
			}
		}

		foreach ($array_map as $num => $row) {
			foreach ($row as $field => $value) {
				if (empty($this->included_fields) || in_array($head[$field], $this->included_fields)) {
					if ($rename_num_field) {
						$this->data[$num][$field] = $value;
					} else {
						$this->data[$num][$head[$field]] = $value;
					}
				}
			}
		}

		$this->data = array_merge($header, $this->data);

		return true;
    }

    /**
     * Carga el CSV en un array dentro de la variable $data
     * @param type $head_first La primera fila del CSV es la cabecera
     * @return boolean Resultado de la inicialización
     */
    public function initialize($head_first = true, $rename_num_field = false) {
		if (!is_file($this->file)) {
			return false;
		}

		$array_map = array_map(array($this,"call_str_getcsv"), preg_split('/\r*\n+|\r+/', file_get_contents($this->file)));

		if (!$head_first) {
			$this->data = $array_map;
			return true;
		}

		return $this->initialize_with_head_first($array_map);
    }

	/**
	 * 
	 * @return boolean
	 */
    public function remove_header() {
		if (!isset($this->data['Header'])) {
			return false;
		}
		unset($this->data['Header']);
		return true;
    }
	
	protected function call_str_getcsv($input) {
		return str_getcsv($input, $this->delimiter);
	}

}
