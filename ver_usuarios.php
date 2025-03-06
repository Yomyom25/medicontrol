<?php
require "utils/conexion.php";
require "utils/seguridad.php";

$id = $_GET['id_usuario'];
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
$resultado = mysqli_query($conectar, $sql);
$fila = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="en">
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
            <a href="usuarios.php" class="btn btn-verde">Regresar</a>
            <div class="user-details">
                <p><strong>Nombre:</strong> <?php echo $fila['nombre']?></p> <hr>
                <p><strong>Email:</strong> <?php echo $fila['correo']; ?></p> <hr>
                <!-- <p><strong>Contraseña:</strong> <?php echo $fila['contraseña']; ?></p> <hr> -->
                <p><strong>Tipo:</strong> <?php echo $fila['tipo']; ?></p> <hr>
            </div>
        </div>

    </div>

</body>
</html>