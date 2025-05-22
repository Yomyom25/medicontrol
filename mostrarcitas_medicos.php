<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>

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
      include "conexion.php";

      // Obtener el ID del médico desde la URL
      $medico_id = isset($_GET['id_medico']) ? intval($_GET['id_medico']) : 0;

      // Validar que el ID del médico es válido
      if ($medico_id > 0) {
        // Consulta SQL para obtener las citas del médico seleccionado
        $query = "
          SELECT 
            p.nombre AS paciente_nombre, 
            p.apellido AS paciente_apellido, 
            c.fecha AS fecha_cita 
          FROM citas c
          INNER JOIN pacientes p ON c.paciente = p.ID_paciente
          WHERE c.medico = ?
          ORDER BY c.fecha ASC
        ";

        // Preparar la consulta
        $stmt = $conectar->prepare($query);
        $stmt->bind_param("i", $medico_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si hay citas
        if ($resultado->num_rows > 0) {
          echo '<table>';
          echo '<thead><tr><th>Nombre del Paciente</th><th>Fecha de la Cita</th></tr></thead><tbody>';
          while ($fila = $resultado->fetch_assoc()) {
            $nombre_completo = $fila['paciente_apellido'] . ' ' . $fila['paciente_nombre'];
            echo "<tr><td>{$nombre_completo}</td><td>{$fila['fecha_cita']}</td></tr>";
          }
          echo '</tbody></table>';
        } else {
          echo '<p class="no-data">No hay citas disponibles para este médico.</p>';
        }

        // Liberar resultados y cerrar la consulta
        $stmt->close();
      } else {
        echo '<p class="no-data">No se encontró un médico válido.</p>';
      }

      // Cerrar la conexión
      $conectar->close();
    ?>
  </div>
</body>
</html>
