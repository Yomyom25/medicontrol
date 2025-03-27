<?php
require "conexion.php";
session_start();

$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
$contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : "";

// verificar si se enviaron datos
if (empty($usuario) || empty($contrasena)) {
    header("Location: index.php?error=campos_vacios&usuario=" . urlencode($usuario));
    exit();
}

// evitar inyección sql
$usuario = mysqli_real_escape_string($conectar, $usuario);

// buscar el usuario en la base de datos
$consulta_usuario = "SELECT nombre, contraseña, tipo FROM usuarios WHERE nombre='$usuario'";
$resultado_usuario = mysqli_query($conectar, $consulta_usuario);

if (mysqli_num_rows($resultado_usuario) == 0) {
    header("Location: index.php?error=usuario_incorrecto");
    exit();
}

// obtener los datos del usuario
$fila_usuario = mysqli_fetch_assoc($resultado_usuario);

// verificar la contraseña
if (password_verify($contrasena, $fila_usuario['contraseña'])) {
    // almacenar datos en la sesión
    $_SESSION["autentificado"] = "SI";
    $_SESSION["nombre"] = $fila_usuario['nombre']; // almacena el nombre
    $_SESSION["tipo"] = $fila_usuario['tipo']; // almacena el tipo de usuario
    
    header("Location: principal.php");
    exit();
} else {
    header("Location: index.php?error=contrasena_incorrecta&usuario=" . urlencode($usuario));
    exit();
}

mysqli_free_result($resultado_usuario);
?>
