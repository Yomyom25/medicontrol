<?php
require "utils/conexion.php";

$usuario = addslashes($_POST["usuario"]);
$contrasena = addslashes($_POST["contrasena"]);

$comparar = "SELECT * FROM usuarios WHERE nombre='$usuario' AND contraseña='$contrasena'";

$resultado = mysqli_query($conectar, $comparar);

if (mysqli_num_rows($resultado) > 0) {
  session_start();
  $_SESSION["autentificado"] = "SI";
  header("Location: principal.php");
} else {

  echo '
    <script> 
      alert("ERROR EN LA AUTENTIFICACION");
      location.href = "index.php?errorusuario=SI";
    </script>
   ';
}
mysqli_free_result($resultado);
