<?php
//  $host = "localhost";
//  $user = "root";
//  $contrasena = "";
//  $bd = "medicontrol_bd";

$host = "localhost";
$user = " jyanmx_medicontrol_user";
$contrasena = "wtC[+@Y^iWEE";
$bd = "jyanmx_medicontrol";

$conectar = mysqli_connect($host, $user, $contrasena, $bd);

if (!$conectar) {
	echo "No se pudo conectar a la base de datos";
}
