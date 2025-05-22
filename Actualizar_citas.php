<?php
require "conexion.php";

$cita_id = addslashes($_POST['cita_id']);
$paciente_id = !empty($_POST['paciente']) ? addslashes($_POST['paciente']) : null;
$fecha = !empty($_POST['fecha_cita']) ? addslashes($_POST['fecha_cita']) : null;
$hora = !empty($_POST['hora_cita']) ? addslashes($_POST['hora_cita']) : null;
$medico_id = !empty($_POST['medico']) ? addslashes($_POST['medico']) : null;

// Obtener datos actuales de la cita
$query_actual = $conectar->prepare("SELECT * FROM citas WHERE ID_citas = ?");
$query_actual->bind_param("i", $cita_id);
$query_actual->execute();
$resultado_actual = $query_actual->get_result();
$cita_actual = $resultado_actual->fetch_assoc();

if (!$cita_actual) {
    echo '<script>alert("Error: Cita no encontrada."); window.history.back();</script>';
    exit();
}

// Validar CURP del paciente si se proporcionó un nuevo paciente
if ($paciente_id) {
    $query_paciente = $conectar->prepare("SELECT curp FROM pacientes WHERE ID_paciente = ?");
    $query_paciente->bind_param("i", $paciente_id);
    $query_paciente->execute();
    $resultado_paciente = $query_paciente->get_result();
    $paciente = $resultado_paciente->fetch_assoc();

    if (!$paciente) {
        echo '<script>alert("Error: Paciente no encontrado."); window.history.back();</script>';
        exit();
    }

    $curp_real = $paciente['curp'];

    // Verificar conflicto de citas del paciente
    if ($fecha && $hora) {
        $query_conflicto_paciente = $conectar->prepare(
            "SELECT * FROM citas WHERE paciente = ? AND fecha = ? AND hora = ? AND ID_citas != ?"
        );
        $query_conflicto_paciente->bind_param("issi", $paciente_id, $fecha, $hora, $cita_id);
        $query_conflicto_paciente->execute();
        $resultado_conflicto_paciente = $query_conflicto_paciente->get_result();

        if ($resultado_conflicto_paciente->num_rows > 0) {
            echo '<script>alert("El paciente ya tiene una cita programada para esta fecha y hora."); window.history.back();</script>';
            exit();
        }
    }
}

// Verificar conflicto de citas del médico
if ($medico_id && $fecha && $hora) {
    $query_conflicto_medico = $conectar->prepare(
        "SELECT * FROM citas WHERE medico = ? AND fecha = ? AND hora = ? AND ID_citas != ?"
    );
    $query_conflicto_medico->bind_param("issi", $medico_id, $fecha, $hora, $cita_id);
    $query_conflicto_medico->execute();
    $resultado_conflicto_medico = $query_conflicto_medico->get_result();

    if ($resultado_conflicto_medico->num_rows > 0) {
        echo '<script>alert("El médico ya tiene una cita programada para esta fecha y hora."); window.history.back();</script>';
        exit();
    }
}

// Preparar actualización dinámica
$campos = [];
$valores = [];

if ($paciente_id) {
    $campos[] = "paciente = ?";
    $valores[] = $paciente_id;
}
if ($fecha) {
    $campos[] = "fecha = ?";
    $valores[] = $fecha;
}
if ($hora) {
    $campos[] = "hora = ?";
    $valores[] = $hora;
}
if ($medico_id) {
    $campos[] = "medico = ?";
    $valores[] = $medico_id;
}

if (empty($campos)) {
    echo '<script>alert("No se realizaron cambios en los datos."); window.history.back();</script>';
    exit();
}

$valores[] = $cita_id;

// Generar consulta SQL dinámica
$sql_update = "UPDATE citas SET " . implode(", ", $campos) . " WHERE ID_citas = ?";
$stmt_update = $conectar->prepare($sql_update);
$stmt_update->bind_param(str_repeat("s", count($valores)), ...$valores);

if ($stmt_update->execute()) {
    echo '<script>alert("La cita se actualizó correctamente."); location.href="dashboard_citas.php";</script>';
} else {
    echo '<script>alert("Error al actualizar la cita."); window.history.back();</script>';
}
exit();
?>
