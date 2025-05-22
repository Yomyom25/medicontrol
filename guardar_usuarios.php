<?php
require "utils/seguridad.php";
require "conexion.php";

header("Content-Type: text/html; charset=UTF-8");

// Validar y sanitizar los datos recibidos
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contrasena = trim($_POST['contraseña'] ?? '');
$tipo = trim($_POST['tipo'] ?? '');

// Validar que los campos no estén vacíos
if (empty($nombre) || empty($correo) || empty($contrasena) || empty($tipo)) {
    echo '<script>
    alert("Todos los campos son obligatorios.");
    location.href = "agregar_usuario.php";
    </script>';
    exit();
}

// Validar formato de correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo '<script>
    alert("El correo no tiene un formato válido.");
    location.href = "agregar_usuario.php";
    </script>';
    exit();
}

// Validar que la contraseña tenga al menos 8 caracteres, una mayúscula y un número
if (strlen($contrasena) < 8 || !preg_match('/[A-Z]/', $contrasena) || !preg_match('/\d/', $contrasena)) {
    echo '<script>
    alert("La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.");
    location.href = "agregar_usuario.php";
    </script>';
    exit();
}

// Encriptar la contraseña
$password = password_hash($contrasena, PASSWORD_BCRYPT);

// Verificar si el correo ya está registrado
$queryVerificar = $conectar->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE correo = ?");
$queryVerificar->bind_param("s", $correo);
$queryVerificar->execute();
$resultadoVerificar = $queryVerificar->get_result();
$fila = $resultadoVerificar->fetch_assoc();

if ($fila['total'] > 0) {
    echo '<script>
    alert("El correo ya está registrado.");
    location.href = "agregar_usuario.php";
    </script>';
    exit();
}

// Insertar el nuevo usuario en la base de datos
$queryInsertar = $conectar->prepare("INSERT INTO usuarios (usuario, correo, contraseña, tipo) VALUES (?, ?, ?, ?)");
$queryInsertar->bind_param("ssss", $nombre, $correo, $password, $tipo);

if ($queryInsertar->execute()) {
    echo '<script>
    alert("Registro exitoso!");
    location.href = "usuarios.php";
    </script>';
} else {
    echo '<script>
    alert("Error al registrar. Intente nuevamente.");
    location.href = "agregar_usuario.php";
    </script>';
}

// Cerrar las consultas y la conexión
$queryVerificar->close();
$queryInsertar->close();
$conectar->close();
?>
