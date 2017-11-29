<?php

class Model extends DB_Operations {

    public function __construct($table, $id_name = 'id') {
        parent::__construct($table, $id_name);
    }

    public function ejecutarSql($query) {
        $my_query = $this->db()->query($query);
        if ($my_query == true) {
            if ($my_query->num_rows > 1) {
                while ($row = $my_query->fetch_object()) {
                    $resultSet[] = $row;
                }
            } elseif ($my_query->num_rows == 1) {
                if ($row = $my_query->fetch_object()) {
                    $resultSet = $row;
                }
            } else {
                $resultSet = true;
            }
        } else {
            $resultSet = false;
        }

        return $resultSet;
    }

    //Aqui podemos montarnos métodos para los modelos de consulta
}
