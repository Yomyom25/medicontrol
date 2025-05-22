<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/agregar_user.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .register-form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .obligatorio-texto {
            color: #666;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 5px;
        }

        button {
            background-color: #6200ea;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4500b5;
        }

        .btn-verde {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-verde:hover {
            background-color: #218838;
        }

        .error-label {
            color: red;
            font-size: 12px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <form class="register-form" action="guardar_usuarios.php" method="POST" id="formRegistro">
            <h2>Registro de Usuario</h2>
            <p class="obligatorio-texto">Todos los campos marcados con (<span class="obligatorio">*</span>) son obligatorios</p>

            <a href="usuarios.php" class="btn-verde">Regresar</a>

            <div class="form-group">
                <label for="nombre">Nombre:<span class="obligatorio">*</span></label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico:<span class="obligatorio">*</span></label>
                <input type="email" id="correo" name="correo" placeholder="Ingresa tu correo electrónico" required>
            </div>

            <div class="form-group">
                <label for="contraseña">Contraseña:<span class="obligatorio">*</span></label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Debe tener 8 caracteres, una mayúscula y un número" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" title="Debe contener al menos 8 caracteres, una mayúscula y un número." required>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo de Usuario:<span class="obligatorio">*</span></label>
                <select id="tipo" name="tipo" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="A">Administrativo</option>
                    <option value="M">Médico</option>
                </select>
            </div>

            <button type="submit" class="registrar">Registrar Usuario</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("formRegistro");

            form.addEventListener("submit", function (event) {
                const nombre = document.getElementById("nombre");
                const correo = document.getElementById("correo");
                const contraseña = document.getElementById("contraseña");
                const tipo = document.getElementById("tipo");

                // Validación de correo
                const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!correoRegex.test(correo.value.trim())) {
                    alert("Por favor ingresa un correo electrónico válido.");
                    event.preventDefault();
                    return;
                }

                // Validación de contraseña
                const contraseñaRegex = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;
                if (!contraseñaRegex.test(contraseña.value)) {
                    alert("La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.");
                    event.preventDefault();
                    return;
                }

                // Validación de tipo de usuario
                if (tipo.value === "") {
                    alert("Por favor selecciona un tipo de usuario.");
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
