<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>
<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Cita Médica</title>
  <link rel="stylesheet" href="css/principal.css">
  <style>
    .contenedor {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

    button.btn-submit {
      background-color: #6200ea;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    button.btn-submit:hover {
      background-color: #4500b5;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h1>Formulario de Citas Médicas</h1>

    <a class="btn-submit" href="dashboard_citas.php">Regresar</a>
    <br>
    
    <form action="guardar_citas.php" method="post">
      <div class="form-group">
        <label>Seleccionar Paciente:</label>
        <select name="paciente" id="select_paciente" required onchange="actualizarCurp()">
          <option value="">Seleccione un paciente...</option>
          <?php
            $query_pacientes = "SELECT ID_paciente, nombre, apellido, curp FROM pacientes ORDER BY apellido, nombre";
            $resultado_pacientes = mysqli_query($conectar, $query_pacientes);
            while ($paciente = $resultado_pacientes->fetch_assoc()) {
              echo '<option value="'.$paciente['ID_paciente'].'" data-curp="'.$paciente['curp'].'">';
              echo htmlspecialchars($paciente['apellido'].' '.$paciente['nombre']);
              echo '</option>';
            }
            mysqli_free_result($resultado_pacientes);
          ?>
        </select>
      </div>

      <div class="form-group">
        <label>CURP:</label>
        <input type="text" name="curp" id="curp_paciente" readonly required>
      </div>

      <div class="form-group">
        <label>Fecha:</label>
        <input type="date" name="fecha_cita" required>
      </div>
      
      <div class="form-group">
        <label>Hora (de 7am a 3pm):</label>
        <input type="time" name="hora_cita" required min="07:00" max="15:00" step="1800">
      </div>

      <div class="form-group">
        <label>Médico Asignado:</label>
        <select name="medico" required>
          <option value="">Seleccione...</option>
          <?php
            $query_medicos = "SELECT * FROM medicos";
            $resultado_medicos = mysqli_query($conectar, $query_medicos);
            while ($medico = $resultado_medicos->fetch_assoc()) {
              echo '<option value="'.$medico['ID_medico'].'">';
              echo htmlspecialchars($medico['nombre']);
              echo '</option>';
            }
            mysqli_free_result($resultado_medicos);
          ?>
        </select>
      </div>

      <button class="btn-submit">Crear Cita</button>
    </form>
  </div>

  <script>
    function actualizarCurp() {
      const selectPaciente = document.getElementById('select_paciente');
      const curpInput = document.getElementById('curp_paciente');
      
      if (selectPaciente.selectedIndex > 0) {
        const curp = selectPaciente.options[selectPaciente.selectedIndex].getAttribute('data-curp');
        curpInput.value = curp;
      } else {
        curpInput.value = '';
      }
    }
  </script>
</body>
</html>
<?php mysqli_close($conectar); ?>