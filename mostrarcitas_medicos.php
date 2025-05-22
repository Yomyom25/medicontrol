<?php include 'header.php';?>
<?php include 'barra_lateral.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mostrar Citas por Médico</title>
  <link rel="stylesheet" href="css/principal.css">
  <style>
    .contenedor {
      margin: 50px auto;
      max-width: 800px;
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f4f4f9;
    }
    .no-data {
      margin-top: 20px;
      font-size: 16px;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h1>Citas del Médico</h1>
    <?php
      // Obtener el nombre del médico desde la URL
      $medico = isset($_GET['medico']) ? htmlspecialchars($_GET['medico']) : 'Desconocido';

      // Simulación de datos de la base de datos
      $citas = [
        'Dr. López' => [
          ['paciente' => 'Juan Pérez', 'fecha' => '2025-05-10'],
          ['paciente' => 'Ana Torres', 'fecha' => '2025-05-15'],
        ],
        'Dr. Martínez' => [
          ['paciente' => 'María Gómez', 'fecha' => '2025-05-12'],
        ],
      ];

      echo "<h2>Médico: $medico</h2>";

      // Verificar si existen citas para el médico
      if (array_key_exists($medico, $citas) && count($citas[$medico]) > 0) {
        echo '<table>';
        echo '<thead><tr><th>Nombre del Paciente</th><th>Fecha de la Cita</th></tr></thead><tbody>';
        foreach ($citas[$medico] as $cita) {
          echo "<tr><td>{$cita['paciente']}</td><td>{$cita['fecha']}</td></tr>";
        }
        echo '</tbody></table>';
      } else {
        echo '<p class="no-data">No hay citas disponibles para este médico.</p>';
      }
    ?>
  </div>
</body>
</html>
