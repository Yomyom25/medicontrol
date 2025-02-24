<?php
if (isset($_SESSION["autentificado"]) && $_SESSION["autentificado"] === "SI") {
    header("Location: principal.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Login</title>
</head>
<body>

<div class="div-1200px">




<div class="prueba"></div>
<div class="img-logo">
    <a href="index.php">
        <img class="logo" src="img/hospital-icon.png" alt="Logo">
    </a>
    </div>

    <div class="background_login">
        <h1>Iniciar sesión</h1>
        <form action="autentificar.php" method="post" name="login_plantilla">
            <?php
            $errorusuario = isset ($_GET["errorusuario"]);
            if($errorusuario == "SI") {
                echo "<p class='error'>Usuario o contraseña incorrectos</p>";
            }
            ?>
            <input type="text" name="usuario" placeholder="Nombre de usuario" class="input-login ancho-uniforme ">
            <input type="password" name="contrasena" placeholder="Contraseña" class="input-login ancho-uniforme ">
             <br>
            <input type="submit" value="Iniciar sesión" class="btn-login ancho-uniforme btn">
        </form>

    </div>
    </div>

</div>
    <script src="scripts/validacion.js"></script> 
</body>
</html>