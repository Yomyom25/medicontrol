<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Médicos</title>
  <link rel="stylesheet" href="css/principal.css">
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
            <option value="">Seleccione...</option>
            <option value="Cardiología">Cardiología</option>
            <option value="Dermatología">Dermatología</option>
            <option value="Pediatría">Pediatría</option>
            <option value="Neurología">Neurología</option>
            <option value="Oncología">Oncología</option>
          </select>
        </div>
      </div> <!-- Cierre del form-box -->

      <button type="submit" class="btn-submit">Registrar Médico</button>
    </form>
  </div>

  <!-- Scripts del código -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Ejemplo de validaciones adicionales
      const cedulaInput = document.querySelector('input[name="cedula"]');
      cedulaInput.addEventListener("input", function() {
        if (cedulaInput.value.length > 50) {
          cedulaInput.value = cedulaInput.value.slice(0, 50);
        }
      });
    });
  </script>
</body>
</html>
