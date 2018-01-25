<?php

class Model extends DBConnection {
	# Constructor y destructor

	/**
	 * Modelo base
	 * @param string $table Nombre de la tabla 
	 * @param string $id_name Nombre del identificador de la tabla
	 */
	public function __construct($table, $id_name = 'id') {
		parent::__construct($table, $id_name);
	}

	function __destruct() {
		
	}

	# Métodos

	/**
	 * Ejecuta una consulta
	 * @param string $query Consulta
	 * @return mixed Resultado de la consulta o false
	 */
	public function executeQuery($query) {
		// Ejecuta la consulta y recupera el resultado
		$query_result = $this->db()->query($query);

		// Si el resultado es false, devuelve false
		if ($query_result === false) {
			return false;
		}

		// Si la consulta devuelve mas de un resultado devuelve un array
		if ($query_result->num_rows > 1) {
			$resultSet = array();
			while ($row = $query_result->fetch_object()) {
				$resultSet[] = $row;
			}
			return $resultSet;

			// Si la consulta devuelve un resultado devuelve el registro
		} elseif ($query_result->num_rows == 1) {
			$row = $query_result->fetch_object();
			if ($row !== false) {
				return $row;
			}
		}

		return $query_result;
	}

}
