<?php
session_start();
require "conexion.php";
include 'header.php';
include 'barra_lateral.php';

// Verificar autenticación
if (!isset($_SESSION["autentificado"])) {
    header("Location: index.php");
    exit();
}

// Obtener datos del usuario autenticado
$usuario_autenticado = $_SESSION["usuario"];
$tipo_usuario = $_SESSION["tipo"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarios.css">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <div class="container">
        <div class="body">
            <h2>Gestión de Usuarios</h2>
            <div class="botones">
                <?php if ($tipo_usuario === 'A') : ?>
                    <a href="agregar_usuario.php" class="btn btn-agregar">Agregar Usuario</a>
                <?php endif; ?>
            </div>

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
                <tbody>
                    <?php
                    $query_usuarios = "SELECT * FROM usuarios ORDER BY ID_usuario ASC";
                    $resultado = mysqli_query($conectar, $query_usuarios);

                    while ($fila = $resultado->fetch_assoc()) {
                        $id_usuario = $fila["ID_usuario"];
                        $nombre_usuario = $fila["usuario"];
                        $correo = $fila["correo"];
                        $tipo = $fila["tipo"];
                    ?>
                    <tr>
                        <td><?php echo $id_usuario; ?></td>
                        <td><?php echo htmlspecialchars($nombre_usuario); ?></td>
                        <td><?php echo htmlspecialchars($correo); ?></td>
                        <td><?php echo $tipo === "A" ? "Administrador" : "Médico"; ?></td>
                        <td><a href="ver_usuarios.php?id_usuario=<?php echo $id_usuario; ?>"><img class="img-tabla" src="img/eye-solid.svg" alt="Ver"></a></td>
                        <td>
                            <?php 
                            $puede_editar = ($tipo_usuario === 'A') || ($usuario_autenticado === $nombre_usuario);
                            if ($puede_editar) : ?>
                                <a href="editar_usuario.php?ID_usuario=<?php echo $id_usuario; ?>"><img class="img-tabla" src="img/pen-to-square-solid.svg" alt="Editar"></a>
                            <?php else : ?>
                                <img class="img-tabla disabled" src="img/pen-to-square-solid.svg" alt="Editar" style="opacity: 0.3; cursor: not-allowed;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $puede_eliminar = ($tipo_usuario === 'A') && ($usuario_autenticado !== $nombre_usuario);
                            if ($puede_eliminar) : ?>
                                <a href="#" onClick="validar('eliminar_usuario.php?ID_usuario=<?php echo $id_usuario; ?>')"><img class="img-tabla" src="img/trash-solid.svg" alt="Eliminar"></a>
                            <?php else : ?>
                                <img class="img-tabla disabled" src="img/trash-solid.svg" alt="Eliminar" style="opacity: 0.3; cursor: not-allowed;">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                    }
                    mysqli_free_result($resultado);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function validar(url) {
            var eliminar = confirm("¿Realmente desea ELIMINAR el registro?");
            if (eliminar) {
                window.location = url;
            }
        }
    </script>
</body>
</html>
