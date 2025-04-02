<?php
require "conexion.php";

$nombre_paciente = addslashes($_POST['nombre']);
$apellido_paciente = addslashes($_POST['apellido']);
$curp_paciente = addslashes($_POST['curp']);
$sexo_paciente = addslashes($_POST['sexo']);
$fecha_paciente = addslashes($_POST['fecha_nacimiento']);

// Verificar si el CURP ya existe en la base de datos
$verificar_curp = "SELECT * FROM pacientes WHERE curp = '$curp_paciente'";
$resultado_verificacion = mysqli_query($conectar, $verificar_curp);

if (mysqli_num_rows($resultado_verificacion) > 0) {
    // Si ya existe, mostrar alerta y regresar al formulario
    echo '
        <script>
            alert("Error: El CURP ingresado ya está registrado.");
            window.history.back(); // Regresa al formulario
        </script>
    ';
    exit();
}


//insertar datos
$insertar_datos = "INSERT INTO pacientes (nombre, apellido, curp, sexo, fecha_nacimineto ) VALUES ('$nombre_paciente','$apellido_paciente','$curp_paciente','$sexo_paciente','$fecha_paciente')";

//instruccion para insertar en la base de datos

$guardar = mysqli_query($conectar, $insertar_datos);

if($guardar){
    echo '
        <script>
            alert("Se guardo correctamnte los datos")
            location.href="Pacientes.php";
        </script>
    ';
}else{
    echo '
        <script>
            alert("no se guardaron correctamente los datos");
            location.href="Pacientes.php";
        </script>
    ';
}
exit();
?>