<?php
require "conexion.php";

// Recuperar el correo y las contraseñas
$correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : "";
$nueva_contrasena = isset($_POST["nueva_contrasena"]) ? trim($_POST["nueva_contrasena"]) : "";
$confirmar_contrasena = isset($_POST["confirmar_contrasena"]) ? trim($_POST["confirmar_contrasena"]) : "";

// Validar que el correo y las contraseñas no estén vacíos
if (empty($correo) || empty($nueva_contrasena) || empty($confirmar_contrasena)) {
    header("Location: cambio_password.php?error=campos_vacios");
    exit();
}

// Validar que las contraseñas coincidan
if ($nueva_contrasena !== $confirmar_contrasena) {
    echo "<script>
            alert('Las contraseñas no coinciden.');
            window.location.href = 'cambio_password.php';
          </script>";
    exit();
}

// Validar que la contraseña tenga al menos 8 caracteres y una letra mayúscula
if (strlen($nueva_contrasena) < 8 || !preg_match('/[A-Z]/', $nueva_contrasena)) {
    echo "<script>
            alert('La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula.');
            window.location.href = 'cambio_password.php';
          </script>";
    exit();
}

// Verificar si el correo existe en la base de datos
$sql_verificar = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conectar, $sql_verificar);

if (mysqli_num_rows($resultado) == 0) {
    // Si no existe el correo, redirige con un error
    echo "<script>
            alert('El correo electrónico no está registrado.');
            window.location.href = 'cambio_password.php';
          </script>";
    exit();
}

// Hashear la nueva contraseña
$hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

// Actualizar la contraseña en la base de datos
$sql = "UPDATE usuarios SET contraseña = '$hashed_password' WHERE correo = '$correo'";

if (mysqli_query($conectar, $sql)) {
    echo "<script>
            alert('Contraseña cambiada exitosamente.');
            window.location.href = 'usuarios.php'; // O redirige donde quieras
          </script>";
} else {
    echo "<script>
            alert('Hubo un error al cambiar la contraseña.');
            window.location.href = 'cambio_password.php';
          </script>";
}

mysqli_close($conectar);
?>
