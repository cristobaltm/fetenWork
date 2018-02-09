<?php

	##############################
	# Constantes predefinidas    #
	# (NO DEBEN SER MODIFICADAS) #
	##############################

# Nombre de la variable GET que define el controlador
define("GET_CONTROLLER", "page");

# Ruta de los modelos
define("PATH_MODELS", "app/model/");

# Ruta de las vistas
define("PATH_VIEWS", "app/view/");

# Ruta de los controladores
define("PATH_CONTROLLERS", "app/controller/");

# Ruta de los controladores
define("PATH_RESOURCES","app/core/resources/");

# Ruta de los archivos de configuración
define("PATH_CONFIG", "config/");

# Ruta de los archivos web
define("PATH_WEB", "web/");

# Ruta de las librerías externas
define("PATH_VENDOR", "vendor/");

// Transforma los datos recogidos en el archivo 'config.yml' en constantes

require_once(PATH_VENDOR . 'spyc/spyc.php');

$config_file = PATH_CONFIG . "config.yml";

$data = Spyc::YAMLLoad($config_file);

foreach ($data as $name => $value) {
	define(strtoupper((string) $name), $value);
}

// Define el entorno (si existe en el archivo env.def, si no el definido por defecto)
$environment = file_get_contents(PATH_CONFIG . "env.def");

if (empty($environment)) {
	$environment = DEFAULT_ENVIRONMENT;
}

define("ENVIRONMENT", $environment);

// Define la ruta del sitio, en función del entorno
if (ENVIRONMENT === 'dev') {
	define("PATH_SITE", PATH_SITE_DEV);
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
	
} else {
	define("PATH_SITE", PATH_SITE_PROD);
}
