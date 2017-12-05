<?php

// Transforma los datos recogidos en el archivo 'config.yml' en constantes

require_once('vendor/spyc/spyc.php');

$config_file = "config/config.yml";

$data = Spyc::YAMLLoad($config_file);

foreach ($data as $name => $value) {
	define(strtoupper((string) $name), $value);
}

// Define el entorno (si existe en el archivo env.def, si no el de por defecto)
$environment = file_get_contents("config/env.def");

if (empty($environment)) {
	$environment = DEFAULT_ENVIRONMENT;
}

define("ENVIRONMENT", $environment);
