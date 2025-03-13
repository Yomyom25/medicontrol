<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>
<?php require "conexion.php"; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarios.css">
    <title>Ver Usuarios</title>
</head>
<body>
    <div class="container">
        <!-- Contenido principal -->
        <div class="body">

            <h2>Ver Usuarios</h2>
            <div class="botones">
                <a href="agregar_usuario.php" class="btn btn-agregar">Agregar Usuarios</a>
            </div>

            <!-- Tabla de usuarios -->
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>

                        <th>Tipo</th>
                        <th>Ver</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                    <?php

                    $todos_usuarios = "SELECT * FROM usuarios ORDER BY id_usuario ASC";
                    $resultado = mysqli_query($conectar, $todos_usuarios);

                    while ($fila = $resultado->fetch_array()) {
                    ?>
                    <tr>
                        <td><?php echo $fila["id_usuario"];?></td>
                        <td><?php echo $fila["nombre"];?></td>
                        <td><?php echo $fila["correo"];?></td>

                        <td><?php echo $fila["tipo"];?></td>
                        <td><a href="ver_usuarios.php?id_usuario=<?php echo $fila['id_usuario']; ?>"><img class="img-tabla" src="img/eye-solid.svg" alt="Ver"></a></td>

                        <td><a href="editar_usuario.php?id_usuario=<?php echo $fila['id_usuario']?>"><img class="img-tabla" src="img//pen-to-square-solid.svg" alt="Editar"></a></td>

                        <td><a href="#" onClick="validar('eliminar_usuario.php?id_usuario=<?php echo $fila['id_usuario']; ?> ')"><img class="img-tabla" src="img/trash-solid.svg" alt="Eliminar"></a></td>
                    </tr>
                    <?php
                         }
                         mysqli_free_result($resultado);
                        ?>
            </table>
        </div>

    </div>

<script>

    function validar(url) {
        var eliminar = confirm("¿Realmente desea ELIMINAR el registro?");
        if (eliminar == true) {
            window.location = url;
        }
     }

</script>

</body>
</html>