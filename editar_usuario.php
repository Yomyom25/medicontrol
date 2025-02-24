
<?php require 'utils/seguridad.php';?>
<?php require "utils/conexion.php";?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios</title>
    <link rel="stylesheet" href="css/agregar_user.css">
</head>
<body>

    <?php
    $id_usuario = $_GET['id_usuario'];
    $verusuario= "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query ($conectar, $verusuario);
    $fila = $resultado->fetch_array();
    ?>

    <div class="dashboard-container">
        <form class="register-form" action="guardar_usuarios2.php" method="POST" onsubmit="return validarEmail()">
            <h2>Editar Usuarios</h2>

            <a href="ver_usuarios.php?id_usuario=<?php echo $fila['id_usuario'];?>" class="btn btn-verde">Regresar</a>

            <div class="form-group">
                <input type="text" id="nombre" name="nombre" value=" <?php echo $fila['nombre']?>" >
            </div>

            <div class="form-group">
                 <?php echo $fila['correo']; ?>
            </div>

            <div class="form-group">
                <input type="password" id="contraseña" name="contraseña" value="<?php echo $fila['contraseña']?>" required>
            </div>

             <!-- Campo Tipo de Usuario -->
             <div class="form-group">
    <select id="tipo" name="tipo" required>
        <option value="" disabled>Selecciona un tipo</option>
        <option value="administrativo">Administrativo</option>
        <option value="medico">Médico</option>
        <option value="paciente">Paciente</option>
    </select>
</div>


            <input type="hidden" name="id_usuario" value="<?php echo $fila["id_usuario"];?>">
            <input type="hidden" name="correo" value="<?php echo $fila["correo"];?>">

            <button class="registrar" type="submit">Guardar Usuario</button>
        </form>
    </div>

    <script>
        // Función para validar el correo electrónico
        function validarEmail() {
            const emailInput = document.getElementById('correo');
            const email = emailInput.value.trim(); // Elimina espacios en blanco al inicio y final

            // Expresión regular para validar el formato del correo electrónico
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Verifica si el campo está vacío
            if (email === "") {
                alert("El campo de correo electrónico no puede estar vacío.");
                return false; // Evita que el formulario se envíe
            }

            // Verifica si el correo tiene un formato válido
            if (!regex.test(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false; // Evita que el formulario se envíe
            }

            return true; // Permite que el formulario se envíe
        }
    </script>
</body>
</html>