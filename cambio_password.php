<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="css/agregar_user.css">
</head>
<body>

    <div class="dashboard-container">
        <form class="register-form" action="cambiar_contrasena.php" method="POST" onsubmit="return validarCorreoYContraseñas()">
            <h2>Cambiar Contraseña</h2>

            <a href="usuarios.php" class="btn btn-verde">Regresar</a>

            <div class="form-group">
                <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required>
            </div>

            <div class="form-group">
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva Contraseña" required>
            </div>

            <div class="form-group">
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required>
            </div>

            <button class="registrar" type="submit">Cambiar Contraseña</button>
        </form>
    </div>

    <script>
        // Validar que el correo esté bien formateado y que las contraseñas coincidan
        function validarCorreoYContraseñas() {
            const emailInput = document.getElementById('correo');
            const email = emailInput.value.trim();

            const nuevaContrasena = document.getElementById('nueva_contrasena').value.trim();
            const confirmarContrasena = document.getElementById('confirmar_contrasena').value.trim();

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === "") {
                alert("El campo de correo electrónico no puede estar vacío.");
                return false;
            }

            if (!regex.test(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false;
            }

            // Validar que las contraseñas coincidan
            if (nuevaContrasena !== confirmarContrasena) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>
