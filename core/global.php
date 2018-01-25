<?php

// Transforma los datos recogidos en el archivo 'config.yml' en constantes

require_once('vendor/spyc/spyc.php');

$config_file = "config/config.yml";

$data = Spyc::YAMLLoad($config_file);

foreach ($data as $name => $value) {
	define(strtoupper((string) $name), $value);
}

// Define el entorno (si existe en el archivo env.def, si no el definido por defecto)
$environment = file_get_contents("config/env.def");

if (empty($environment)) {
	$environment = DEFAULT_ENVIRONMENT;
}

define("ENVIRONMENT", $environment);

// Define la ruta del sitio, en función del entorno
if (ENVIRONMENT === 'dev') {
	define("PATH_SITE", PATH_SITE_DEV);
} else {
	define("PATH_SITE", PATH_SITE_PROD);
}

###########################
# Constantes predefinidas #
# (no se deben modificar) #
###########################
# Nombre de la variable GET que define el controlador
define("GET_CONTROLLER", "page");

# Ruta de los modelos
define("PATH_MODELS", "model/");

# Ruta de las vistas
define("PATH_VIEWS", "view/");

# Ruta de los controladores
define("PATH_CONTROLLERS", "controller/");

# Ruta de los archivos web
define("PATH_WEB", "web/");
