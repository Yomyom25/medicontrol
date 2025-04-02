<?php
//Archivo para guardar los usuarios agregados en el DashBoard
require "conexion.php";

$apellido_id = addslashes($_POST['paciente']); // ID del paciente seleccionado
$curp_p = addslashes($_POST['curp']);
$fecha = addslashes($_POST['fecha_cita']);
$hora = addslashes($_POST['hora_cita']);
$especialidad = addslashes($_POST['especialidad']);
$medico = addslashes($_POST['medico']);

// Obtener el CURP del paciente seleccionado según su ID
$consulta_paciente = "SELECT curp FROM pacientes WHERE id_pacientes = '$apellido_id'";
$resultado_paciente = mysqli_query($conectar, $consulta_paciente);
$fila_paciente = mysqli_fetch_assoc($resultado_paciente);

if ($fila_paciente) {
    $curp_real = $fila_paciente['curp']; // CURP correcto según la BD

    // Verificar si el CURP ingresado coincide con el CURP de la BD
    if ($curp_real !== $curp_p) {
        echo '
            <script>
                alert("El CURP ingresado no coincide con el paciente seleccionado.");
                window.history.back(); // Regresar al formulario
            </script>
        ';
        exit();
    }

    // Si el CURP es correcto, insertamos la cita en la BD
    $insertar_datos = "INSERT INTO citas (apellido_paciente, curp_paciente, fecha, hora, especialidad, medico) 
                       VALUES ('$apellido_id', '$curp_p', '$fecha', '$hora', '$especialidad', '$medico')";

    $guardar_dash = mysqli_query($conectar, $insertar_datos);

    if ($guardar_dash) {
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