<?php
// Conexión a la base de datos
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y validar los datos del formulario
    $nombre = trim($_POST["nombre"] ?? '');
    $cedula = trim($_POST["cedula"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $tel_contacto = trim($_POST["tel_contacto"] ?? '');
    $especialidad = trim($_POST["especialidad"] ?? '');
    $usuario = trim($_POST["usuario"] ?? '');

    // Validar campos obligatorios
    if (empty($nombre) || empty($cedula) || empty($email) || empty($especialidad) || empty($usuario)) {
        echo "<script>
            alert('Por favor, complete todos los campos obligatorios.');
            window.history.back();
        </script>";
        exit();
    }

    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('El correo no tiene un formato válido.');
            window.history.back();
        </script>";
        exit();
    }

    // Validar que la cédula sea un número válido
    if (!is_numeric($cedula)) {
        echo "<script>
            alert('La cédula debe contener solo números.');
            window.history.back();
        </script>";
        exit();
    }

    // Preparar la consulta SQL para insertar el médico
    $queryInsertar = $conectar->prepare("
        INSERT INTO medicos (nombre, cedula, email, tel_contacto, especialidad, usuario) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $queryInsertar->bind_param("sssssi", $nombre, $cedula, $email, $tel_contacto, $especialidad, $usuario);

    if ($queryInsertar->execute()) {
        echo "<script>
            alert('Médico registrado exitosamente.');
            window.location.href = 'lista_medicos.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al registrar el médico: " . $queryInsertar->error . "');
            window.history.back();
        </script>";
    }

    // Cerrar la consulta y la conexión
    $queryInsertar->close();
    $conectar->close();
} else {
    echo "<script>
        alert('Acceso no autorizado.');
        window.location.href = 'index.php';
    </script>";
}
?>
