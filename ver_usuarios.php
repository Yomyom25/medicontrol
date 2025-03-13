<?php
require "conexion.php";
require "utils/seguridad.php";

// Protege contra la inyección de SQL
$id_usuario = $_GET['id_usuario']; // Usamos GET para obtener el ID de la URL

// Asegúrate de que se pasó un ID válido
if (empty($id_usuario)) {
    echo '<script>
    alert("ID de usuario no válido.");
    location.href = "usuarios.php"; // Redirige si no se pasa un ID
    </script>';
    exit();
}

$sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'"; // Consulta SQL con el ID recibido
$resultado = mysqli_query($conectar, $sql);

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
} else {
    echo '<script>
    alert("Error al obtener los datos del usuario.");
    location.href = "usuarios.php"; // Redirige si hay un error en la consulta
    </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarios.css">
    <title>Detalles del Usuario</title>
</head>
<body>

 <!-- Header -->
 <?php include "header.php"; ?>
 <!-- Sidebar -->
 <?php include "barra_lateral.php"; ?>
    <div class="container">

        <!-- Contenido principal -->
        <div class="body">

            <h2>Detalles del Usuario</h2>
            <a href="ver_usuarios.php" class="btn btn-verde">Regresar</a> <!-- Corregir URL del botón regresar -->
            <div class="user-details">
                <p><strong>Nombre:</strong> <?php echo $fila['nombre']?></p> <hr>
                <p><strong>Email:</strong> <?php echo $fila['correo']; ?></p> <hr>
                <p><strong>Tipo:</strong> <?php echo $fila['tipo']; ?></p> <hr>
            </div>
        </div>

    </div>

</body>
</html>
