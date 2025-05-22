<?php
session_start(); // Asegurarse de que la sesión está iniciada
require "conexion.php";
include 'header.php';
include 'barra_lateral.php';

// Obtener el nombre del usuario autenticado
$usuario_autenticado = $_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarios.css">
    <title>Lista de Médicos</title>
</head>
<body>
    <div class="container">
        <div class="body">
            <h2>Lista de Médicos</h2>
            <div class="botones">
                <a href="medicos.php" class="btn btn-agregar">Agregar Médico</a>
            </div>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Especialidad</th>
                        <th>Citas</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $todos_medicos = "SELECT * FROM medicos ORDER BY id_medicos ASC";
                    $resultado = mysqli_query($conectar, $todos_medicos);

                    while ($fila = $resultado->fetch_array()) {
                        $id_medico = $fila["id_medicos"];
                        $nombre_medico = $fila["nombre"];
                    ?>
                    <tr>
                        <td><?php echo $id_medico; ?></td>
                        <td><?php echo $nombre_medico; ?></td>
                        <td><?php echo $fila["cedula"]; ?></td>
                        <td><?php echo $fila["email"]; ?></td>
                        <td><?php echo $fila["tel_contacto"]; ?></td>
                        <td><?php echo $fila["especialidad"]; ?></td>
                        <td><a href="mostrarcitas_medicos.php?id_medico=<?php echo $id_medico; ?>"><img class="img-tabla" src="img/eye-solid.svg" alt="Ver"></a></td>
                        
                        <td>
                            <a href="editar_medico.php?id_medico=<?php echo $id_medico; ?>"><img class="img-tabla" src="img/pen-to-square-solid.svg" alt="Editar"></a>
                        </td>
                        
                        <td>
                            <a href="#" onClick="validar('eliminar_medico.php?id_medico=<?php echo $id_medico; ?>')"><img class="img-tabla" src="img/trash-solid.svg" alt="Eliminar"></a>
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
            if (eliminar == true) {
                window.location = url;
            }
        }
    </script>
</body>
</html>
