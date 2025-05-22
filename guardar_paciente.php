<?php
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y validar los datos del formulario
    $nombre_paciente = trim($_POST['nombre'] ?? '');
    $apellido_paciente = trim($_POST['apellido'] ?? '');
    $curp_paciente = trim($_POST['curp'] ?? '');
    $sexo_paciente = trim($_POST['sexo'] ?? '');
    $fecha_paciente = trim($_POST['fecha_nacimiento'] ?? '');

    // Validar campos obligatorios
    if (empty($nombre_paciente) || empty($apellido_paciente) || empty($curp_paciente) || empty($sexo_paciente) || empty($fecha_paciente)) {
        echo '
            <script>
                alert("Por favor, complete todos los campos obligatorios.");
                window.history.back();
            </script>
        ';
        exit();
    }

    // Validar formato del CURP (18 caracteres alfanuméricos)
    if (!preg_match('/^[A-Z0-9]{18}$/', $curp_paciente)) {
        echo '
            <script>
                alert("El CURP debe tener exactamente 18 caracteres alfanuméricos.");
                window.history.back();
            </script>
        ';
        exit();
    }

    // Verificar si el CURP ya existe en la base de datos
    $queryVerificar = $conectar->prepare("SELECT COUNT(*) AS total FROM pacientes WHERE curp = ?");
    $queryVerificar->bind_param("s", $curp_paciente);
    $queryVerificar->execute();
    $resultadoVerificar = $queryVerificar->get_result();
    $fila = $resultadoVerificar->fetch_assoc();

    if ($fila['total'] > 0) {
        echo '
            <script>
                alert("Error: El CURP ingresado ya está registrado.");
                window.history.back();
            </script>
        ';
        exit();
    }

    // Insertar los datos del paciente
    $queryInsertar = $conectar->prepare("
        INSERT INTO pacientes (nombre, apellido, curp, sexo, fecha_nacimiento) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $queryInsertar->bind_param("sssss", $nombre_paciente, $apellido_paciente, $curp_paciente, $sexo_paciente, $fecha_paciente);

    if ($queryInsertar->execute()) {
        echo '
            <script>
                alert("El paciente ha sido registrado correctamente.");
                location.href = "Pacientes.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al registrar el paciente: ' . $queryInsertar->error . '");
                window.history.back();
            </script>
        ';
    }

    // Cerrar consultas y conexión
    $queryVerificar->close();
    $queryInsertar->close();
    $conectar->close();
} else {
    echo '
        <script>
            alert("Acceso no autorizado.");
            location.href = "index.php";
        </script>
    ';
    exit();
}
?>
