<?php 
session_start();
include 'header.php';
include 'barra_lateral.php';

// verificar si el usuario está autenticado
if (!isset($_SESSION["autentificado"])) {
    header("Location: index.php");
    exit();
}

// obtener el tipo de usuario y nombre
$tipo_usuario = isset($_SESSION["tipo"]) ? $_SESSION["tipo"] : "usuario";
$nombre_usuario = isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "Invitado";

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/principal.css">
</head>
<body>

  <div class="contenedor">
    <h1>PANEL PRINCIPAL</h1>

    <?php if ($tipo_usuario === "administrativo") : ?>
      <h2 style="color: green;">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h2>
    <?php else : ?>
      <h2 style="color: blue;">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h2>
    <?php endif; ?>

    <div class="img-principal">
      <img class="principal" src="img/house-solid.svg" alt="principal">
    </div>
  </div>

</body>
</html>
