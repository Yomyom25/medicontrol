<?php
include 'utils/conexion.php';

$id_usuario = $_GET['id_usuario'];

// Eliminar el usuario
$eliminar = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
$resultado = mysqli_query($conectar, $eliminar);

if ($resultado) {
    header("Location: usuarios.php");
} else {
    echo "Error al eliminar el dato: " . $conectar->error;
}

$conectar->close();
?>