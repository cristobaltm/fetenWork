<?php

class View {

    public function url($controlador = DEFAULT_CONTROLLER, $accion = DEFAULT_ACTION) {
        $urlString = "index.php?controller={$controlador}&action={$accion}";
        return $urlString;
    }

    //Helpers para las vistas
}
