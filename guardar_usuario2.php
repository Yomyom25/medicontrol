<?php
require 'conexion.php';
require 'utils/seguridad.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar los datos del formulario
    $id_usuario = isset($_POST['ID_usuario']) ? intval($_POST['ID_usuario']) : 0;
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';

    // Validaciones básicas
    if (empty($id_usuario) || empty($usuario) || empty($correo) || empty($tipo)) {
        echo '<script>
            alert("Todos los campos son obligatorios.");
            location.href = "editar_usuario.php?ID_usuario=' . $id_usuario . '";
        </script>';
        exit();
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
            alert("Correo electrónico inválido.");
            location.href = "editar_usuario.php?ID_usuario=' . $id_usuario . '";
        </script>';
        exit();
    }

    // Actualizar los datos en la base de datos
    $query = $conectar->prepare("UPDATE usuarios SET usuario = ?, tipo = ? WHERE ID_usuario = ?");
    $query->bind_param("ssi", $usuario, $tipo, $id_usuario);

    if ($query->execute()) {
        echo '<script>
            alert("Usuario actualizado correctamente.");
            location.href = "usuarios.php";
        </script>';
    } else {
        echo '<script>
            alert("Ocurrió un error al actualizar el usuario. Intenta nuevamente.");
            location.href = "editar_usuario.php?ID_usuario=' . $id_usuario . '";
        </script>';
    }

    $query->close();
} else {
    echo '<script>
        alert("Acceso no autorizado.");
        location.href = "usuarios.php";
    </script>';
}
