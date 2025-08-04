<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Credenciales de conexión a la base de datos
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'inventarios';

// Conexión a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Fallo en la conexión de MySQL: ' . mysqli_connect_error());
}

?>