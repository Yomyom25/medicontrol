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

            <button type="submit">Guardar</button>
            <a href="usuarios.php" class="btn btn-regresar">Cancelar</a>
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
