<?php
// Conexión a la base de datos
include "conexion.php";

// Verificar que el formulario se haya enviado correctamente
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $nombre = mysqli_real_escape_string($conectar, $_POST["nombre"]);
    $cedula = mysqli_real_escape_string($conectar, $_POST["cedula"]);
    $email = mysqli_real_escape_string($conectar, $_POST["email"]);
    $tel_contacto = mysqli_real_escape_string($conectar, $_POST["tel_contacto"]);
    $especialidad = mysqli_real_escape_string($conectar, $_POST["especialidad"]);

    // Validar datos requeridos
    if (empty($nombre) || empty($cedula) || empty($email) || empty($especialidad)) {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.'); window.history.back();</script>";
        exit();
    }

    // Insertar los datos en la tabla medicos
    $sql = "INSERT INTO medicos (nombre, cedula, email, tel_contacto, especialidad) 
            VALUES ('$nombre', '$cedula', '$email', '$tel_contacto', '$especialidad')";

    if (mysqli_query($conectar, $sql)) {
        echo "<script>alert('Médico registrado exitosamente.'); window.location.href='lista_medicos.php';</script>";
    } else {
        echo "<script>alert('Error al registrar el médico: " . mysqli_error($conectar) . "'); window.history.back();</script>";
    }

    // Cerrar la conexión
    mysqli_close($conectar);
} else {
    echo "<script>alert('Acceso no autorizado.'); window.location.href='index.php';</script>";
}
?>
