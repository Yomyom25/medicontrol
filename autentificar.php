<?php
require "conexion.php";

$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
$contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : "";

// Si falta usuario o contraseña
if (empty($usuario) || empty($contrasena)) {
    header("Location: index.php?error=campos_vacios&usuario=" . urlencode($usuario));
    exit();
}

// Evitar inyección SQL
$usuario = mysqli_real_escape_string($conectar, $usuario);

// Verificar si el usuario existe
$consulta_usuario = "SELECT * FROM usuarios WHERE nombre='$usuario'";
$resultado_usuario = mysqli_query($conectar, $consulta_usuario);

if (mysqli_num_rows($resultado_usuario) == 0) {
    header("Location: index.php?error=usuario_incorrecto");
    exit();
}

// Obtener los datos del usuario
$fila_usuario = mysqli_fetch_assoc($resultado_usuario);

// Verificar si la contraseña es correcta
if (password_verify($contrasena, $fila_usuario['contraseña'])) {
    session_start();
    $_SESSION["autentificado"] = "SI";
    header("Location: principal.php");
} else {
    header("Location: index.php?error=contrasena_incorrecta&usuario=" . urlencode($usuario));
}

mysqli_free_result($resultado_usuario);
?>
