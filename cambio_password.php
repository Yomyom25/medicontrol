<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="css/agregar_user.css">
    <style>
        .obligatorio {
            color: red;
            font-weight: bold;
        }
        .obligatorio-texto {
            color: #666;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        .requisitos-contrasena {
            color: #666;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .campo-obligatorio::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <form class="register-form" action="cambiar_contrasena.php" method="POST" onsubmit="return validarCorreoYContraseñas()">
            <h2>Cambiar Contraseña</h2>
            <p class="obligatorio-texto">Todos los campos marcados con (<span class="obligatorio">*</span>) son obligatorios</p>

            <a href="usuarios.php" class="btn btn-verde">Regresar</a>

            <div class="form-group">
                <label class="campo-obligatorio">Correo electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo electrónico" required>
            </div>

            <div class="form-group">
                <label class="campo-obligatorio">Nueva Contraseña</label>
                <p class="requisitos-contrasena">La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula y un número</p>
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Ingrese nueva contraseña" required>
            </div>

            <div class="form-group">
                <label class="campo-obligatorio">Confirmar Contraseña</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Repita la nueva contraseña" required>
            </div>

            <button class="registrar" type="submit">Cambiar Contraseña</button>
        </form>
    </div>

    <script>
        // Validar que el correo esté bien formateado y que las contraseñas coincidan
        function validarCorreoYContraseñas() {
            const emailInput = document.getElementById('correo');
            const email = emailInput.value.trim();

            const nuevaContrasena = document.getElementById('nueva_contrasena').value;
            const confirmarContrasena = document.getElementById('confirmar_contrasena').value;

            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const regexPassword = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

            // Validar correo
            if (email === "") {
                alert("El campo de correo electrónico no puede estar vacío.");
                return false;
            }

            if (!regexEmail.test(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false;
            }

            // Validar que las contraseñas coincidan
            if (nuevaContrasena !== confirmarContrasena) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            // Validar fortaleza de contraseña
            if (!regexPassword.test(nuevaContrasena)) {
                alert("La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula y un número.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>