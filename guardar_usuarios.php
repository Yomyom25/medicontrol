<?php
require "utils/seguridad.php";
require "conexion.php";

// Proteccion de inyecciones SQL
$nombre = addslashes($_POST['nombre']);
$correo = addslashes($_POST['correo']);
$contrasena = addslashes($_POST['contraseña']);
$tipo = addslashes($_POST['tipo']);

// Validar que el correo tenga un formato correcto
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo '<script>
    alert("El correo no tiene un formato válido.");
    location.href = "agregar_usuario.php";
    </script>';
    exit(); // Salir para evitar continuar con el registro
}

// Validar que la contraseña tenga al menos 8 caracteres y una mayúscula
if (strlen($contrasena) < 8 || !preg_match('/[A-Z]/', $contrasena)) {
    echo '<script>
    alert("La contraseña debe tener al menos 8 caracteres y una letra mayúscula.");
    location.href = "agregar_usuario.php";
    </script>';
    exit(); // Salir para evitar continuar con el registro
}

// Encriptar contraseña
$password = password_hash($contrasena, PASSWORD_BCRYPT);

// Validar si el correo ya está registrado
$verificar = mysqli_query($conectar, "SELECT * FROM usuarios WHERE correo = '$correo'");

if (mysqli_num_rows($verificar) > 0) {
    echo '<script>
    alert("El correo ya está registrado!");
    location.href = "agregar_usuario.php";
    </script>';
    exit(); // Salimos para evitar ejecutar la consulta de insertar si el usuario ya existe
}

// Consulta SQL para insertar los datos en la tabla usuarios
$insertar = "INSERT INTO usuarios (nombre, correo, contraseña, tipo) VALUES ('$nombre', '$correo', '$password', '$tipo')";

// Ejecutar la consulta
$query = mysqli_query($conectar, $insertar);

// Aviso
if ($query) {
    echo '<script>
    alert("Registro exitoso!");
    location.href = "usuarios.php";
    </script>';
} else {
    echo '<script>
    alert("Error al registrar!");
    location.href = "agregar_usuario.php";
    </script>';
}
?>
