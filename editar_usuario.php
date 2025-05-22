<?php 
require 'utils/seguridad.php'; 
require 'conexion.php'; 
include 'header.php'; 
include 'barra_lateral.php'; 

if (!isset($_GET['ID_usuario']) || !is_numeric($_GET['ID_usuario'])) {
    echo '<script>
        alert("ID de usuario inválido.");
        location.href = "usuarios.php";
    </script>';
    exit();
}

$id_usuario = intval($_GET['ID_usuario']);

$query = $conectar->prepare("SELECT * FROM usuarios WHERE ID_usuario = ?");
$query->bind_param("i", $id_usuario);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows === 0) {
    echo '<script>
        alert("El usuario no existe.");
        location.href = "usuarios.php";
    </script>';
    exit();
}

$fila = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/agregar_user.css">
    <style>
        /* Estilos mejorados para los botones */
        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            flex: 1;
            min-width: 120px;
        }
        
        .btn-primary {
            background-color: #6200ea;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #4500b5;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
        }
        
        /* Estilos para el formulario */
        .register-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .register-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <form class="register-form" action="guardar_usuario2.php" method="POST" onsubmit="return validarEmail()">
            <h2>Editar Usuario</h2>

            <div class="form-group">
                <label>Nombre </label>
                <input type="text" name="usuario" value="<?php echo htmlspecialchars($fila['usuario']); ?>" required>
            </div>

            <div class="form-group">
                <label>Correo electrónico </label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($fila['correo']); ?>" readonly required>
            </div>

            <div class="form-group">
                <label>Tipo de usuario</label>
                <select name="tipo" required>
                    <option value="A" <?php echo $fila['tipo'] === 'A' ? 'selected' : ''; ?>>Administrador</option>
                    <option value="M" <?php echo $fila['tipo'] === 'M' ? 'selected' : ''; ?>>Médico</option>
                </select>
            </div>

            <input type="hidden" name="ID_usuario" value="<?php echo $fila['ID_usuario']; ?>">

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="cambio_password.php?ID_usuario=<?php echo $fila['ID_usuario']; ?>" class="btn btn-warning">Cambiar Contraseña</a>
                <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function validarEmail() {
            const email = document.querySelector('input[name="correo"]').value.trim();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>