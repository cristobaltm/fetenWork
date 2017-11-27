<?php

class ModeloBase extends EntidadBase {

    private $table;
    private $fluent;

    public function __construct($table) {
        $this->table = (string) $table;
        parent::__construct($table);

        $this->fluent = $this->getConetar()->startFluent();
    }

    public function fluent() {
        return $this->fluent;
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
