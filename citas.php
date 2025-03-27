<?php include 'header.php';?>
<?php include 'barra_lateral.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/principal.css">
</head>
<body>
  <div class="contenedor">
    <h1>Formulario de Citas Médicas</h1>
    
    <!-- Datos del Paciente -->
    <div class="form-box">
      <h2>Datos del Paciente</h2>
      <div class="form-group">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
      </div>
      <div class="form-group">
        <label>Apellido:</label>
        <input type="text" name="apellido" required>
      </div>
      <div class="form-group">
        <label>Curp:</label>
        <input type="text" name="identificacion" required>
      </div>
      <div class="form-group">
        <label>Sexo:</label>
        <select name="sexo" required>
          <option value="">Seleccione...</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select>
      </div>
      <div class="form-group">
        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required>
      </div>
    </div>

    <!-- Datos de la Cita -->
    <div class="form-box">
      <h2>Datos de la Cita</h2>
      <div class="form-group">
        <label>Fecha:</label>
        <input type="date" name="fecha_cita" required>
      </div>
      <div class="form-group">
        <label>Hora:</label>
        <input type="time" name="hora_cita" required>
      </div>
      <div class="form-group">
        <label>Especialidad:</label>
        <select name="especialidad" required>
          <option value="">Seleccione...</option>
          <option value="Cardiología">Cardiología</option>
          <option value="Dermatología">Dermatología</option>
          <option value="Pediatría">Pediatría</option>
        </select>
      </div>
      <div class="form-group">
        <label>Médico Asignado:</label>
        <input type="text" name="medico_asignado" required>
      </div>
    </div>
    
    <button class="btn-submit">Crear Cita</button>
  </div>
</body>
</html>