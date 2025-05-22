<?php
require "conexion.php";

if ($conectar) {
    echo "Conexión exitosa a la base de datos";
} else {
    echo "Error en la conexión: " . mysqli_connect_error();
}
?>
