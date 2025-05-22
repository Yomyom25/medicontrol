<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Médicos</title>
  <link rel="stylesheet" href="css/principal.css">
  <style>
    .contenedor {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-box {
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input, select, button {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ddd;
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
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <?php include 'barra_lateral.php'; ?>

  <div class="contenedor">
    <h1>Formulario de Gestión de Médicos</h1>

    <form action="guardar_medicos.php" method="post">
      <!-- Datos del Médico -->
      <div class="form-box">
        <h2>Datos del Médico</h2>

        <div class="form-group">
          <label>Nombre:</label>
          <input type="text" name="nombre" required placeholder="Nombre completo del médico">
        </div>

        <div class="form-group">
          <label>Cédula Profesional:</label>
          <input type="text" name="cedula" required placeholder="Cédula profesional">
        </div>

        <div class="form-group">
          <label>Email:</label>
          <input type="email" name="email" required placeholder="Correo electrónico">
        </div>

        <div class="form-group">
          <label>Teléfono de Contacto:</label>
          <input type="tel" name="tel_contacto" placeholder="Número de contacto">
        </div>

        <div class="form-group">
          <label>Especialidad:</label>
          <select name="especialidad" required>
            <option value="">Seleccione una especialidad...</option>
            <?php
              include "conexion.php";
              $especialidades = "SELECT * FROM especialidades ORDER BY nombre_especialidad ASC";
              $resultado = mysqli_query($conectar, $especialidades);

              while ($fila = $resultado->fetch_assoc()) {
                  echo "<option value='{$fila['ID_especialidad']}'>{$fila['nombre_especialidad']}</option>";
              }
              mysqli_free_result($resultado);
            ?>
          </select>
        </div>

        <div class="form-group">
          <label>Usuario:</label>
          <select name="usuario" required>
            <option value="">Seleccione un usuario...</option>
            <?php
              $usuarios = "SELECT ID_usuario, usuario FROM usuarios";
              $resultadoUsuarios = mysqli_query($conectar, $usuarios);

              while ($filaUsuario = $resultadoUsuarios->fetch_assoc()) {
                  echo "<option value='{$filaUsuario['ID_usuario']}'>{$filaUsuario['usuario']}</option>";
              }
              mysqli_free_result($resultadoUsuarios);
            ?>
          </select>
        </div>
      </div>

      <button type="submit" class="btn-submit">Registrar Médico</button>
    </form>
  </div>

  <!-- Validaciones -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const cedulaInput = document.querySelector('input[name="cedula"]');
      
      // Limitar la longitud de la cédula
      cedulaInput.addEventListener("input", function () {
        if (cedulaInput.value.length > 50) {
          cedulaInput.value = cedulaInput.value.slice(0, 50);
        }
      });
    });
  </script>
</body>
</html>

