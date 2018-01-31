<?php

// Configuración global
require_once 'app/core/global.php';

// Base para los controladores
require_once 'app/core/Application.php';

// Recuperamos las variables pasadas por la URL
$url_var = explode('/', filter_input(INPUT_GET, GET_CONTROLLER));

// Cargamos controladores y acciones
$application = new Application();
$application->setUrl_var($url_var);
$application->load();
$application->execute();
