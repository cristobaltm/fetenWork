<?php

// Datos de conexión a Base de Datos por defecto
$database = array(
	"driver" => "mysql",
	"host" => "localhost",
	"user" => "root",
	"pass" => "",
	"database" => "mvc",
	"charset" => "utf8"
);

// Datos de conexión a Base de Datos si el entorno es de desarrollo
if (ENVIRONMENT == 'dev') {
	$database = array(
		"driver" => "mysql",
		"host" => "localhost",
		"user" => "root",
		"pass" => "",
		"database" => "mvc_dev",
		"charset" => "utf8"
	);
}

return $database;
