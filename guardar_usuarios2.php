<?php
require "utils/seguridad.php";

$id_usuario = $_POST ['id_usuario'];
$nombre = $_POST ['nombre'];
$correo = $_POST ['correo'];
$contraseña = $_POST ['contraseña'];
$tipo = $_POST ['tipo'];

require "utils/conexion.php";

$actualizar = "UPDATE usuarios SET nombre='$nombre', correo = '$correo', contraseña = '$contraseña', tipo = '$tipo' WHERE id_usuario = '$id_usuario'";

$query = mysqli_query($conectar, $actualizar);

if($query){
  echo '
  <script>
    alert("SE GUARDO LOS DATOS CORRECTAMENTE");
    location.href = "ver_usuarios.php?id_usuario=' . $id_usuario . ' ";
  </script>';
} else {
  echo '
  <script>
    alert("NO SE GUARDARON LOS DATOS");
    location.href = "editar_usuario.php?id_usuario=' . $id_usuario . ' ";
  </script>';
}


?>