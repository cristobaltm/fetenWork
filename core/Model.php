<?php

class Model extends DBConnection {

    public function __construct($table, $id_name = 'id') {
        parent::__construct($table, $id_name);
    }

    public function executeQuery($query) {
        $my_query = $this->db()->query($query);
	
        if ($my_query === false) {
	    return false;
	}
	
	if ($my_query->num_rows > 1) {
	    $resultSet = array();
	    while ($row = $my_query->fetch_object()) {
		$resultSet[] = $row;
	    }
	    return $resultSet;
	    
	} elseif ($my_query->num_rows == 1) {
	    $row = $my_query->fetch_object();
	    if ($row !== false) {
		return $row;
	    }
	}

        return true;
    }

    //Aqui podemos montarnos métodos para los modelos de consulta
}
