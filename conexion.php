<?php
$host = "localhost";
$user = "jyanmx_user";
$contrasena = "wtC[+@Y^iWEE";
$bd = "jyanmx_medicontrol";

$conectar = mysqli_connect($host, $user, $contrasena, $bd);

// Validar la conexión
if (!$conectar) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Establecer el conjunto de caracteres a UTF-8
mysqli_set_charset($conectar, "utf8");
?>
