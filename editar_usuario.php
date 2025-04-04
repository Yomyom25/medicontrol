<?php require 'utils/seguridad.php'; ?>
<?php require 'conexion.php'; ?>
<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios</title>
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
        .campo-obligatorio::after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>

    <?php
    $id_usuario = $_GET['id_usuario'];
    $verusuario = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conectar, $verusuario);
    $fila = $resultado->fetch_array();
    ?>

    <div class="dashboard-container">
        <form class="register-form" action="guardar_usuario2.php" method="POST" onsubmit="return validarEmail()">
            <h2>Editar Usuario</h2>
            <p class="obligatorio-texto">Todos los campos marcados con (<span class="obligatorio">*</span>) son obligatorios</p>

            <div class="btn-new">
                <a href="cambio_password.php" class="btn-azul">Modificar la contraseña</a>
            </div>

            <a href="ver_usuarios.php?id_usuario=<?php echo $fila['id_usuario']; ?>" class="btn btn-verde">Regresar</a>

            <!-- Nombre -->
            <div class="form-group">
                <label class="campo-obligatorio">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo trim($fila['nombre']); ?>" placeholder="Nombre" required>
            </div>

            <!-- Mostrar correo (solo lectura) -->
            <div class="form-group">
                <label class="campo-obligatorio">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="<?php echo trim($fila['correo']); ?>" placeholder="Correo" readonly required>
            </div>

            <!-- Tipo de usuario -->
            <div class="form-group">
                <label class="campo-obligatorio">Tipo de usuario</label>
                <select id="tipo" name="tipo" required>
                    <option value="" disabled <?php echo empty($fila['tipo']) ? 'selected' : ''; ?>>Selecciona un tipo</option>
                    <option value="administrativo" <?php echo ($fila['tipo'] == 'administrativo') ? 'selected' : ''; ?>>Administrativo</option>
                    <option value="medico" <?php echo ($fila['tipo'] == 'medico') ? 'selected' : ''; ?>>Médico</option>
                </select>
            </div>

            <!-- Campos ocultos -->
            <input type="hidden" name="id_usuario" value="<?php echo $fila['id_usuario']; ?>">
            <input type="hidden" name="password" value="<?php echo $fila['contraseña']; ?>">

            <button class="registrar" type="submit">Guardar Usuario</button>
            <br>
        </form>
    </div>

    <script>
        // Función para validar el correo electrónico
        function validarEmail() {
            const emailInput = document.getElementById('correo');
            const email = emailInput.value.trim();

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === "") {
                alert("El campo de correo electrónico no puede estar vacío.");
                return false;
            }

            if (!regex.test(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>