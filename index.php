<?php

// Configuración global, define todas las constantes
require_once 'app/core/global.php';

// Clase principal con la aplicación
require_once 'app/core/Application.php';

// Recuperamos las variables pasadas por la URL
$url_var = explode('/', filter_input(INPUT_GET, GET_CONTROLLER));

// Iniciamos la aplicación, cargamos las variables y ejecutamos
$application = new Application();
$application->setUrl_var($url_var);
$application->load();
$application->execute();
