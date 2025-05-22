
<?php
require "conexion.php";

$paciente_id = addslashes($_POST['paciente']); // ID del paciente seleccionado
$curp_formulario = addslashes($_POST['curp']);
$fecha = addslashes($_POST['fecha_cita']);
$hora = addslashes($_POST['hora_cita']);
$especialidad_id = addslashes($_POST['especialidad']);
$medico_id = addslashes($_POST['medico']);

// Obtener CURP real
$consulta_paciente = "SELECT curp FROM pacientes WHERE id_pacientes = '$paciente_id'";
$resultado_paciente = mysqli_query($conectar, $consulta_paciente);
$fila_paciente = mysqli_fetch_assoc($resultado_paciente);

if ($fila_paciente) {
    $curp_real = $fila_paciente['curp'];

    if ($curp_real !== $curp_formulario) {
        echo '
            <script>
                alert("El CURP ingresado no coincide con el paciente seleccionado.");
                window.history.back();
            </script>
        ';
        exit();
    }

    // --- 1. Validar que el paciente NO tenga ya una cita el mismo día ---
    $consulta_cita_paciente = "SELECT * FROM citas WHERE curp_paciente = '$curp_real' AND fecha = '$fecha'";
    $resultado_cita_paciente = mysqli_query($conectar, $consulta_cita_paciente);

    if (mysqli_num_rows($resultado_cita_paciente) > 0) {
        echo '
            <script>
                alert("Usted ya tiene una cita agendada para este día.");
                window.history.back();
            </script>
        ';
        exit();
    }

    // --- 2. Validar que el doctor NO tenga cita a la misma fecha y hora ---
    $consulta_cita_doctor = "SELECT * FROM citas WHERE medico = '$medico_id' AND fecha = '$fecha' AND hora = '$hora'";
    $resultado_cita_doctor = mysqli_query($conectar, $consulta_cita_doctor);

    if (mysqli_num_rows($resultado_cita_doctor) > 0) {
        echo '
            <script>
                alert("Este doctor ya tiene una cita a esa hora.");
                window.history.back();
            </script>
        ';
        exit();
    }

    // Todo está bien, insertar cita
    $insertar_cita = "INSERT INTO citas (apellido_paciente, curp_paciente, fecha, hora, especialidad, medico) 
                      VALUES ('$paciente_id', '$curp_real', '$fecha', '$hora', '$especialidad_id', '$medico_id')";

    $guardar_cita = mysqli_query($conectar, $insertar_cita);

    if ($guardar_cita) {
        echo '
            <script>
                alert("Se guardó correctamente la cita.");
                location.href="citas.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al guardar la cita.");
                location.href="citas.php";
            </script>
        ';
    }

} else {
    echo '
        <script>
            alert("Error: No se encontró el paciente en la base de datos.");
            window.history.back();
        </script>
    ';
}

exit();
?>