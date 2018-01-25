<?php

// Configuración global
require_once 'core/global.php';

// Base para los controladores
require_once 'core/Controller.php';

// Recuperamos las variables pasadas por la URL
$url_var = explode('/', filter_input(INPUT_GET, GET_CONTROLLER));

// Cargamos controladores y acciones
$controller = new Controller();
$controller->setUrl_var($url_var);
$controller->load();
$controller->execute();
