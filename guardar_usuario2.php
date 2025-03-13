<?php
require "utils/seguridad.php";
require "conexion.php";

// Protección contra inyecciones SQL y limpieza de datos
$id_usuario = addslashes($_POST['id_usuario']);
$nombre = addslashes($_POST['nombre']);
$correo = addslashes($_POST['correo']); // viene oculto en el formulario y solo lectura
$password = addslashes($_POST['password']); // viene oculto
$tipo = addslashes($_POST['tipo']);

// Validación del correo (aunque es readonly, por seguridad se valida)
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo '<script>
    alert("El correo no tiene un formato válido.");
    location.href = "editar_usuario.php?id_usuario=' . $id_usuario . '";
    </script>';
    exit(); // Detener el proceso si el correo no es válido
}

// Consulta SQL para actualizar los datos del usuario
$actualizar = "UPDATE usuarios SET 
                nombre = '$nombre', 
                tipo = '$tipo', 
                contraseña = '$password'
              WHERE id_usuario = '$id_usuario'";

// Ejecutar la consulta
$query = mysqli_query($conectar, $actualizar);

// Mensaje de resultado
if ($query) {
    echo '<script>
    alert("Usuario actualizado exitosamente!");
    location.href = "ver_usuarios.php?id_usuario=' . $id_usuario . '";
    </script>';
} else {
    echo '<script>
    alert("Error al actualizar usuario. Intenta nuevamente.");
    location.href = "editar_usuario.php?id_usuario=' . $id_usuario . '";
    </script>';
}
?>
