<?php
require "conexion.php";

$nombre = addslashes($_POST ['nombre']);
$correo = addslashes($_POST['correo']);
$contraseña = addslashes($_POST['contraseña']);
$tipo = addslashes($_POST['tipo']);


// Validar usuario
$verificar  = mysqli_query($conectar, "SELECT * FROM usuarios WHERE correo = '$correo' ");

if (mysqli_num_rows($verificar) > 0){
    echo '<script>
    alert("El correo ya está registrado!");
    location.href = "usuarios.php"
    </script>';
    exit();  // Salimos para evitar ejecutar la consulta de insertar si el usuario ya existe.
}

// Consulta SQL para insertar los datos en la tabla usuarios
$insertar = "INSERT INTO usuarios (nombre, correo, contraseña, tipo) VALUES ('$nombre', '$correo', '$contraseña', '$tipo' )";

// Ejecutar la consulta
$query = mysqli_query($conectar, $insertar);

// Aviso
if ($query) {
    echo '<script>
    alert("Registro exitoso!");
    location.href = "usuarios.php"
    </script>';
} else {
    echo '<script>
    alert("Error al registrar!");
    location.href = "index.php"
    </script>';
}
?>