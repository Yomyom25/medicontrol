<?php
include 'conexion.php';

header('Content-Type: application/json');

$cita_id = $_GET['id'] ?? 0;

try {
    // Verificar si la cita existe
    $query = "SELECT estatus FROM citas WHERE ID_citas = ?";
    $stmt = $conectar->prepare($query);
    $stmt->bind_param("i", $cita_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Cita no encontrada']);
        exit();
    }
    
    $cita = $result->fetch_assoc();
    
    if ($cita['estatus'] === 'R') {
        echo json_encode(['success' => false, 'message' => 'La cita ya está marcada como realizada']);
        exit();
    }
    
    // Actualizar el estado
    $update = "UPDATE citas SET estatus = 'R' WHERE ID_citas = ?";
    $stmt = $conectar->prepare($update);
    $stmt->bind_param("i", $cita_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el estado']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
}

$stmt->close();
$conectar->close();
?>