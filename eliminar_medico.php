<?php
session_start(); // Iniciar sesión
require "conexion.php";

// Verificar si se pasó un ID válido por la URL
if (isset($_GET["id_medico"])) {
    $id_medico = intval($_GET["id_medico"]); // Asegurarse de que el ID sea un número entero

    // Consulta para eliminar el médico
    $sql = "DELETE FROM medicos WHERE id_medicos = ?";
    $stmt = $conectar->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id_medico);
        if ($stmt->execute()) {
            echo "<script>alert('Médico eliminado correctamente.'); window.location.href='lista_medicos.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar el médico: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error al preparar la consulta.'); window.history.back();</script>";
    }

    $conectar->close();
} else {
    echo "<script>alert('ID de médico no válido.'); window.history.back();</script>";
}
?>
