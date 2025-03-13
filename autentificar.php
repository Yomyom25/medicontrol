<?php
require "utils/conexion.php";

$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
$contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : "";

// Si falta usuario o contraseña
if (empty($usuario) || empty($contrasena)) {
    header("Location: index.php?error=campos_vacios&usuario=" . urlencode($usuario));
    exit();
}

// Evitar inyección SQL
$usuario = mysqli_real_escape_string($conectar, $usuario);
$contrasena = mysqli_real_escape_string($conectar, $contrasena);

// Verificar si el usuario existe
$consulta_usuario = "SELECT * FROM usuarios WHERE nombre='$usuario'";
$resultado_usuario = mysqli_query($conectar, $consulta_usuario);

if (mysqli_num_rows($resultado_usuario) == 0) {
    header("Location: index.php?error=usuario_incorrecto");
    exit();
}

// Verificar si la contraseña es correcta
$consulta_contrasena = "SELECT * FROM usuarios WHERE nombre='$usuario' AND contraseña='$contrasena'";
$resultado_contrasena = mysqli_query($conectar, $consulta_contrasena);

if (mysqli_num_rows($resultado_contrasena) > 0) {
    session_start();
    $_SESSION["autentificado"] = "SI";
    header("Location: principal.php");
} else {
    header("Location: index.php?error=contrasena_incorrecta&usuario=" . urlencode($usuario));
}

mysqli_free_result($resultado_usuario);
mysqli_free_result($resultado_contrasena);
?>

