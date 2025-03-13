<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/agregar_user.css">
</head>
<body>

    <div class="dashboard-container">
        <form class="register-form" action="guardar_usuarios.php" method="POST" onsubmit="return validarEmail()">
            <h2>Registro</h2>

            <a href="usuarios.php" class="btn btn-verde">Regresar</a>

            <div class="form-group">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" >
            </div>

            <div class="form-group">
                <input type="correo" id="correo" name="correo" placeholder="Correo electrónico" >
            </div>

            <div class="form-group">
                <label for="" ><b>La contraseña debe tener 8 caracteres y una mayúscula</b></label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
            </div>


            <div class="form-group">
                <select id="tipo" name="tipo" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="Medico">Medico</option>
                </select>
            </div>


            <button class="registrar" type="submit">Registrarse</button>
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