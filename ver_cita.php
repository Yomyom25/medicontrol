<?php 
include 'header.php';
include 'barra_lateral.php';
include 'conexion.php';

$cita_id = $_GET['id'] ?? 0;

// Consulta para obtener todos los detalles de la cita
$query = "
    SELECT 
        c.ID_citas, 
        c.fecha, 
        c.hora, 
        c.estatus,
        p.ID_paciente,
        p.nombre AS nombre_paciente, 
        p.apellido AS apellido_paciente,
        p.curp,
        p.sexo,
        p.fecha_nacimiento,
        m.ID_medico,
        m.nombre AS nombre_medico,
        m.cedula,
        m.email AS email_medico,
        m.tel_contacto,
        e.nombre_especialidad,
        c.notas
    FROM citas c
    INNER JOIN pacientes p ON c.paciente = p.ID_paciente
    INNER JOIN medicos m ON c.medico = m.ID_medico
    INNER JOIN especialidades e ON m.especialidad = e.ID_especialidad
    WHERE c.ID_citas = ?
";

$stmt = $conectar->prepare($query);
$stmt->bind_param("i", $cita_id);
$stmt->execute();
$resultado = $stmt->get_result();
$cita = $resultado->fetch_assoc();

if (!$cita) {
    echo '<script>alert("Cita no encontrada."); location.href = "dashboard_citas.php";</script>';
    exit();
}

$fecha_nacimiento = new DateTime($cita['fecha_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($fecha_nacimiento)->y;

$estado_cita = ($cita['estatus'] == 'R') ? 'Realizada' : 'Pendiente';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalles de Cita Médica</title>
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
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }

    .valor {
      padding: 8px;
      background: #f9f9f9;
      border-radius: 4px;
      margin-top: 5px;
    }

    .btn-container {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .btn {
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
      cursor: pointer;
    }

    .btn-back {
      background-color: #6c757d;
      color: white;
      border: none;
    }

    .btn-back:hover {
      background-color: #5a6268;
    }

    .btn-realizada {
      background-color: #28a745;
      color: white;
      border: none;
      <?php if ($cita['estatus'] == 'R') echo 'display: none;'; ?>
    }

    .btn-realizada:hover {
      background-color: #218838;
    }

    .btn-notas {
      background-color: #007bff;
      color: white;
      border: none;
    }

    .btn-notas:hover {
      background-color: #0056b3;
    }

    .btn-reporte {
      background-color: #17a2b8;
      color: white;
      border: none;
    }

    .btn-reporte:hover {
      background-color: #138496;
    }

    .estado-realizada {
      color: #28a745;
      font-weight: bold;
    }

    .estado-pendiente {
      color: #dc3545;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h1>Detalles de la Cita Médica</h1>

    <div class="form-group">
      <label>Información del Paciente:</label>
      <div class="valor">
        <strong>Nombre completo:</strong> <?php echo htmlspecialchars($cita['apellido_paciente'] . ' ' . $cita['nombre_paciente']); ?><br>
        <strong>Edad:</strong> <?php echo $edad; ?> años<br>
        <strong>Sexo:</strong> <?php echo ($cita['sexo'] == 'M') ? 'Masculino' : 'Femenino'; ?><br>
        <strong>CURP:</strong> <?php echo htmlspecialchars($cita['curp']); ?>
      </div>
    </div>

    <div class="form-group">
      <label>Información del Médico:</label>
      <div class="valor">
        <strong>Nombre:</strong> <?php echo htmlspecialchars($cita['nombre_medico']); ?><br>
        <strong>Especialidad:</strong> <?php echo htmlspecialchars($cita['nombre_especialidad']); ?><br>
        <strong>Contacto:</strong> <?php echo htmlspecialchars($cita['tel_contacto']); ?><br>
        <strong>Email:</strong> <?php echo htmlspecialchars($cita['email_medico']); ?>
      </div>
    </div>

    <div class="form-group">
      <label>Detalles de la Cita:</label>
      <div class="valor">
        <strong>Fecha:</strong> <?php echo htmlspecialchars($cita['fecha']); ?><br>
        <strong>Hora:</strong> <?php echo htmlspecialchars(substr($cita['hora'], 0, 5)); ?><br>
        <strong>Estado:</strong> 
        <span class="<?php echo ($cita['estatus'] == 'R') ? 'estado-realizada' : 'estado-pendiente'; ?>">
          <?php echo $estado_cita; ?>
        </span>
      </div>
    </div>

    <?php if (!empty($cita['notas'])): ?>
    <div class="form-group">
      <label>Notas:</label>
      <div class="valor">
        <?php echo nl2br(htmlspecialchars($cita['notas'])); ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="btn-container">
      <a href="dashboard_citas.php" class="btn btn-back">Regresar</a>
      
      <?php if ($cita['estatus'] != 'R'): ?>
        <button onclick="marcarComoRealizada()" class="btn btn-realizada">Marcar como Realizada</button>
      <?php else: ?>
        <a href="agregar_notas.php?id=<?php echo $cita_id; ?>" class="btn btn-notas">Agregar Notas</a>
        <a href="reporte_cita.php?id=<?php echo $cita_id; ?>" class="btn btn-reporte">Generar Reporte</a>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function marcarComoRealizada() {
      if (confirm('¿Está seguro que desea marcar esta cita como realizada? Esta acción no se puede deshacer.')) {
        fetch('marcar_realizada.php?id=<?php echo $cita_id; ?>')
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('La cita ha sido marcada como realizada.');
              location.reload();
            } else {
              alert('Error al actualizar el estado: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al procesar la solicitud.');
          });
      }
    }
  </script>
</body>
</html>

<?php 
$stmt->close();
$conectar->close();
?>
