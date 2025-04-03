<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/principal.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <?php include 'barra_lateral.php'; ?>
  
  <div class="contenedor">
    <h1>Formulario de Citas Médicas</h1>
    
    <form action="guardar_citas.php" method="post">
      <!-- Datos de la Cita -->
      <div class="form-box">
        <h2>Datos de la cita</h2>
        
        <div class="form-group">
          <label>Apellido del paciente:</label>
          <select name="paciente" required>
            <option value="">Seleccione...</option>
            <?php
              include "conexion.php";
              $ver_pacientes = "SELECT * FROM pacientes";
              $resultado = mysqli_query($conectar, $ver_pacientes);
              while ($fila = $resultado->fetch_assoc()) {
                  echo '<option value="'.$fila["id_pacientes"].'">'.$fila["apellido"].'</option>';
              }
              mysqli_free_result($resultado);
            ?>
          </select>
        </div>
        
        <div class="form-group">
          <label>Curp:</label>
          <input type="text" name="curp" required>
        </div>

        <div class="form-group">
          <label>Fecha:</label>
          <input type="date" name="fecha_cita" required>
        </div>
        
        <div class="form-group">
          <label>Hora (de 7am a 3pm):</label>
          <input type="time" name="hora_cita" required min="07:00" max="15:00">
        </div>

        <div class="form-group">
          <label>Especialidad:</label>
          <select name="especialidad" required>
            <option value="">Seleccione...</option>
            <?php
              $ver_especialidad = "SELECT * FROM especialidad";
              $resultado = mysqli_query($conectar, $ver_especialidad);
              while ($fila = $resultado->fetch_assoc()) {
                  echo '<option value="'.$fila["id_especialidad"].'">'.$fila["nombre_especialidad"].'</option>';
              }
              mysqli_free_result($resultado);
            ?>
          </select>
        </div>

        <div class="form-group">
          <label>Médico Asignado:</label>
          <select name="medico" required>
            <option value="">Seleccione...</option>
            <?php
              $ver_medico = "SELECT * FROM medicos";
              $resultado = mysqli_query($conectar, $ver_medico);
              while ($fila = $resultado->fetch_assoc()) {
                  echo '<option value="'.$fila["id_medicos"].'">'.$fila["nombre"].'</option>';
              }
              mysqli_free_result($resultado);
            ?>
          </select>
        </div>
      </div> <!-- Cierre del form-box -->
      
      <button type="submit" class="btn-submit">Crear Cita</button>
    </form>
  </div>

  <!-- Scripts del código -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Validación de CURP (18 caracteres)
      let curpInput = document.querySelector('input[name="curp"]');
      
      curpInput.addEventListener("input", function() {
        if (curpInput.value.length > 18) {
          curpInput.value = curpInput.value.slice(0, 18);
        }
      });

      document.querySelector("form").addEventListener("submit", function(event) {
        if (curpInput.value.length !== 18) {
          alert("El CURP debe tener exactamente 18 caracteres.");
          event.preventDefault();
        }
      });

      // Validación de horario (7am a 3pm)
      let horaInput = document.querySelector('input[name="hora_cita"]');

      horaInput.addEventListener("change", function() {
        let horaSeleccionada = horaInput.value;
        let minHora = "07:00";
        let maxHora = "15:00";

        if (horaSeleccionada < minHora || horaSeleccionada > maxHora) {
          alert("Por favor, selecciona una hora entre 7:00 AM y 3:00 PM.");
          horaInput.value = "";
        }
      });
    });
  </script>
</body>
</html>