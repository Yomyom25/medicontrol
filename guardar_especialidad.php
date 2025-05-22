<?php
// Conexión a la base de datos
include "conexion.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir y validar los datos del POST
    $nuevaEspecialidad = isset($_POST["nueva_especialidad"]) ? trim($_POST["nueva_especialidad"]) : "";

    if (empty($nuevaEspecialidad)) {
        echo json_encode([
            "success" => false,
            "message" => "El campo de nueva especialidad está vacío."
        ]);
        exit();
    }

    // Verificar si la especialidad ya existe
    $queryExistente = $conectar->prepare("SELECT COUNT(*) AS total FROM especialidades WHERE nombre_especialidad = ?");
    $queryExistente->bind_param("s", $nuevaEspecialidad);
    $queryExistente->execute();
    $resultado = $queryExistente->get_result();
    $fila = $resultado->fetch_assoc();

    if ($fila["total"] > 0) {
        echo json_encode([
            "success" => false,
            "message" => "La especialidad ya existe."
        ]);
        exit();
    }

    // Insertar la nueva especialidad en la base de datos
    $queryInsertar = $conectar->prepare("INSERT INTO especialidades (nombre_especialidad) VALUES (?)");
    $queryInsertar->bind_param("s", $nuevaEspecialidad);

    if ($queryInsertar->execute()) {
        // Obtener el ID de la nueva especialidad
        $nuevoId = $queryInsertar->insert_id;

        echo json_encode([
            "success" => true,
            "id" => $nuevoId,
            "message" => "Especialidad agregada correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al agregar la especialidad. Inténtelo nuevamente."
        ]);
    }

    // Cerrar la conexión y las consultas
    $queryInsertar->close();
    $conectar->close();
} else {
    // Responder con un error si no es una solicitud POST
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
    exit();
}
