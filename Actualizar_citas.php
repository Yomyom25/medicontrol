

<?php
require "conexion.php";

$cita_id = addslashes($_POST['cita_id']);
$paciente_id = addslashes($_POST['paciente']); // ID del paciente seleccionado
$curp_formulario = addslashes($_POST['curp']);
$fecha = addslashes($_POST['fecha_cita']);
$hora = addslashes($_POST['hora_cita']);
$especialidad_id = addslashes($_POST['especialidad']);
$medico_id = addslashes($_POST['medico']);

// Obtener los datos actuales de la cita
$consulta_actual = "SELECT * FROM citas WHERE id_citas = '$cita_id'";
$resultado_actual = mysqli_query($conectar, $consulta_actual);
$cita_actual = mysqli_fetch_assoc($resultado_actual);

if (!$cita_actual) {
    echo '<script>alert("Error: No se encontró la cita en la base de datos."); window.history.back();</script>';
    exit();
}

// Validar si los datos capturados son iguales a los actuales
if (
    $cita_actual['curp_paciente'] === $curp_real &&
    $cita_actual['fecha'] === $fecha &&
    $cita_actual['hora'] === $hora &&
    $cita_actual['especialidad'] === $especialidad_id &&
    $cita_actual['medico'] === $medico_id
) {
    echo '<script>alert("No se ha realizado ningún cambio en los datos."); window.history.back();</script>';
    exit();
}

// Verificar si no se ingresaron nuevos datos
if (empty($fecha) || empty($hora) || empty($especialidad_id) || empty($medico_id)) {
    echo '<script>alert("Por favor, complete todos los campos para actualizar la cita."); window.history.back();</script>';
    exit();
}

// Verificar que el CURP ingresado coincida con el del paciente seleccionado
$consulta_paciente = "SELECT curp FROM pacientes WHERE id_pacientes = '$paciente_id'";
$resultado_paciente = mysqli_query($conectar, $consulta_paciente);
$fila_paciente = mysqli_fetch_assoc($resultado_paciente);

if ($fila_paciente) {
    $curp_real = $fila_paciente['curp'];

    if ($curp_real !== $curp_formulario) {
        echo '<script>alert("El CURP ingresado no coincide con el paciente seleccionado."); window.history.back();</script>';
        exit();
    }

    // Validar que el paciente NO tenga ya una cita el mismo día y hora
    $consulta_cita_paciente = "SELECT * FROM citas WHERE curp_paciente = '$curp_real' AND fecha = '$fecha' AND hora = '$hora' AND id_citas != '$cita_id'";
    $resultado_cita_paciente = mysqli_query($conectar, $consulta_cita_paciente);

    if (mysqli_num_rows($resultado_cita_paciente) > 0) {
        echo '<script>alert("Usted ya tiene una cita agendada para este día y hora."); window.history.back();</script>';
        exit();
    }

    // Validar que el doctor NO tenga cita a la misma fecha y hora
    $consulta_cita_doctor = "SELECT * FROM citas WHERE medico = '$medico_id' AND fecha = '$fecha' AND hora = '$hora' AND id_citas != '$cita_id'";
    $resultado_cita_doctor = mysqli_query($conectar, $consulta_cita_doctor);

    if (mysqli_num_rows($resultado_cita_doctor) > 0) {
        echo '<script>alert("Este doctor ya tiene una cita a esa hora."); window.history.back();</script>';
        exit();
    }

    // Todo está bien, actualizar la cita
    $actualizar_cita = "UPDATE citas SET curp_paciente = '$curp_real', fecha = '$fecha', hora = '$hora', especialidad = '$especialidad_id', medico = '$medico_id' WHERE id_citas = '$cita_id'";
    $resultado_actualizar = mysqli_query($conectar, $actualizar_cita);

    if ($resultado_actualizar) {
        echo '<script>alert("La cita se ha actualizado correctamente."); location.href="dashboard_citas.php";</script>';
    } else {
        echo '<script>alert("Error al actualizar la cita."); window.history.back();</script>';
    }

} else {
    echo '<script>alert("Error: No se encontró el paciente en la base de datos."); window.history.back();</script>';
}

exit();
?>