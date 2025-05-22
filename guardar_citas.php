<?php
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paciente_id = trim($_POST['paciente'] ?? '');
    $medico_id = trim($_POST['medico'] ?? '');
    $fecha_cita = trim($_POST['fecha_cita'] ?? '');
    $hora_cita = trim($_POST['hora_cita'] ?? '');

    if (empty($paciente_id) || empty($medico_id) || empty($fecha_cita) || empty($hora_cita)) {
        echo '<script>alert("Por favor, complete todos los campos obligatorios."); window.history.back();</script>';
        exit();
    }

    $fecha_actual = date("Y-m-d");
    if ($fecha_cita < $fecha_actual) {
        echo '<script>alert("La fecha de la cita no puede ser anterior al día actual."); window.history.back();</script>';
        exit();
    }

    if ($hora_cita < "07:00" || $hora_cita > "15:00") {
        echo '<script>alert("La hora debe estar entre 7:00 AM y 3:00 PM."); window.history.back();</script>';
        exit();
    }

    // Inserción con el campo estatus
    $estatus = 'P'; // P de Pendiente
    $query = $conectar->prepare("INSERT INTO citas (paciente, medico, fecha, hora, estatus) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("iisss", $paciente_id, $medico_id, $fecha_cita, $hora_cita, $estatus);

    if ($query->execute()) {
        echo '<script>alert("Cita registrada exitosamente."); location.href = "dashboard_citas.php";</script>';
    } else {
        echo '<script>alert("Error al registrar la cita: ' . $query->error . '"); window.history.back();</script>';
    }

    $query->close();
    $conectar->close();
} else {
    echo '<script>alert("Acceso no autorizado."); location.href = "index.php";</script>';
}
?>
