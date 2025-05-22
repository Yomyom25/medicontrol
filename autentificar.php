<?php
require "conexion.php";
session_start();

// Obtener y limpiar datos del formulario
$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
$contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : "";

// Validar campos obligatorios
if (empty($usuario) || empty($contrasena)) {
    header("Location: index.php?error=campos_vacios&usuario=" . urlencode($usuario));
    exit();
}

// Consulta preparada para evitar inyecciones SQL
$query = $conectar->prepare("SELECT ID_usuario, usuario, correo, contraseña, tipo FROM usuarios WHERE usuario = ?");
$query->bind_param("s", $usuario);
$query->execute();
$resultado = $query->get_result();

// Verificar si el usuario existe
if ($resultado->num_rows === 0) {
    header("Location: index.php?error=usuario_incorrecto");
    exit();
}

// Obtener los datos del usuario
$fila_usuario = $resultado->fetch_assoc();

// Verificar la contraseña
if (password_verify($contrasena, $fila_usuario['contraseña'])) {
    // Iniciar sesión
    $_SESSION["autentificado"] = "SI";
    $_SESSION["ID_usuario"] = $fila_usuario['ID_usuario'];
    $_SESSION["usuario"] = $fila_usuario['usuario']; // Nombre de usuario
    $_SESSION["correo"] = $fila_usuario['correo'];
    $_SESSION["tipo"] = $fila_usuario['tipo'];

    // Redirigir al panel principal
    header("Location: principal.php");
    exit();
} else {
    header("Location: index.php?error=contrasena_incorrecta&usuario=" . urlencode($usuario));
    exit();
}

// Liberar recursos y cerrar conexión
$query->close();
$conectar->close();
?>