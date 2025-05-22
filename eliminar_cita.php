<?php
session_start(); // Iniciar sesión
require "conexion.php";

// Verificar si se pasó un ID válido por la URL
if (isset($_GET["id"])) {
    $id_cita = intval($_GET["id"]); // Asegurarse de que el ID sea un número entero

    // Consultar el estatus de la cita
    $sql_status = "SELECT estatus FROM citas WHERE ID_citas = ?";
    $stmt_status = $conectar->prepare($sql_status);

    if ($stmt_status) {
        $stmt_status->bind_param("i", $id_cita);
        $stmt_status->execute();
        $stmt_status->bind_result($estatus);
        $stmt_status->fetch();
        $stmt_status->close();

        // Verificar si el estatus es "R"
        if ($estatus === 'R') {
            echo "<script>alert('La cita no se puede eliminar porque fue realizada.'); window.history.back();</script>";
            exit();
        }

        // Proceder con la eliminación si el estatus no es "R"
        $sql = "DELETE FROM citas WHERE ID_citas = ?";
        $stmt = $conectar->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id_cita);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Cita eliminada correctamente.'); window.location.href='dashboard_citas.php';</script>";
                } else {
                    echo "<script>alert('Error: La cita no existe o ya fue eliminada.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Error al eliminar la cita: " . $stmt->error . "'); window.history.back();</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error al preparar la consulta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error al consultar el estatus de la cita.'); window.history.back();</script>";
    }

    $conectar->close();
} else {
    echo "<script>alert('ID de cita no válido.'); window.history.back();</script>";
}
?>
