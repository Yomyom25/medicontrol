<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>
<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Citas Médicas</title>
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
    <h1>Editar Citas Médicas</h1>
    <a class="btn-submit" href="dashboard_citas.php">Regresar</a>
    <br>

    <?php
    // Recuperar datos de la cita
    $cita_id = $_GET['id'];
    $query_cita = $conectar->prepare("SELECT * FROM citas WHERE ID_citas = ?");
    $query_cita->bind_param("i", $cita_id);
    $query_cita->execute();
    $resultado_cita = $query_cita->get_result();
    $cita = $resultado_cita->fetch_assoc();

    if (!$cita) {
        echo '<script>alert("Cita no encontrada."); location.href = "dashboard_citas.php";</script>';
        exit();
    }

    // Obtener información del paciente actual
    $query_paciente_actual = $conectar->prepare("SELECT nombre, apellido FROM pacientes WHERE ID_paciente = ?");
    $query_paciente_actual->bind_param("i", $cita['paciente']);
    $query_paciente_actual->execute();
    $resultado_paciente_actual = $query_paciente_actual->get_result();
    $paciente_actual = $resultado_paciente_actual->fetch_assoc();

    $esRealizado = $cita['estatus'] === 'R'; // Comprobar si el estatus es "Realizado"
    ?>

    <form action="Actualizar_citas.php" method="post">
      <input type="hidden" name="cita_id" value="<?php echo $cita['ID_citas']; ?>">

      <div class="form-group">
        <label>Paciente:</label>
        <select name="paciente" <?php if ($esRealizado) echo 'disabled'; ?>>
          <?php
          // Obtener todos los pacientes
          $query_pacientes = "SELECT ID_paciente, nombre, apellido FROM pacientes ORDER BY apellido, nombre";
          $resultado_pacientes = mysqli_query($conectar, $query_pacientes);
          
          while ($paciente = $resultado_pacientes->fetch_assoc()) {
              $selected = ($cita['paciente'] == $paciente['ID_paciente']) ? 'selected' : '';
              echo '<option value="' . $paciente['ID_paciente'] . '" ' . $selected . '>';
              echo htmlspecialchars($paciente['apellido'] . ' ' . $paciente['nombre']);
              echo '</option>';
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label>Médico:</label>
        <select name="medico" <?php if ($esRealizado) echo 'disabled'; ?>>
          <?php
          $query_medicos = "SELECT ID_medico, nombre FROM medicos";
          $resultado_medicos = mysqli_query($conectar, $query_medicos);
          while ($medico = $resultado_medicos->fetch_assoc()) {
              $selected = $cita['medico'] == $medico['ID_medico'] ? 'selected' : '';
              echo '<option value="' . $medico['ID_medico'] . '" ' . $selected . '>' . htmlspecialchars($medico['nombre']) . '</option>';
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label>Fecha:</label>
        <input type="date" name="fecha_cita" value="<?php echo $cita['fecha']; ?>" <?php if ($esRealizado) echo 'disabled'; ?>>
      </div>

      <div class="form-group">
        <label>Hora:</label>
        <input type="time" name="hora_cita" value="<?php echo $cita['hora']; ?>" <?php if ($esRealizado) echo 'disabled'; ?> min="07:00" max="15:00" step="1800">
      </div>

      <div class="form-group">
        <label>Estatus:</label>
        <input type="text" value="<?php echo $cita['estatus'] === 'R' ? 'Realizado' : 'Pendiente'; ?>" readonly>
      </div>

      <?php if (!$esRealizado): ?>
      <button class="btn-submit">Actualizar Cita</button>
      <?php else: ?>
      <p style="color: red; font-weight: bold;">Esta cita ya está marcada como realizada y no puede ser editada.</p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
<?php 
$query_cita->close();
$query_paciente_actual->close();
if (isset($resultado_pacientes)) mysqli_free_result($resultado_pacientes);
if (isset($resultado_medicos)) mysqli_free_result($resultado_medicos);
$conectar->close(); 
?>