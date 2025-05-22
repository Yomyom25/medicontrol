<?php
include 'header.php';
include 'barra_lateral.php';
include 'conexion.php';

$cita_id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notas = $_POST['notas'] ?? '';

    $query = "UPDATE citas SET notas = ? WHERE ID_citas = ?";
    $stmt = $conectar->prepare($query);
    $stmt->bind_param('si', $notas, $cita_id);

    if ($stmt->execute()) {
        echo '<script>alert("Notas guardadas correctamente."); location.href = "ver_cita.php?id=' . $cita_id . '";</script>';
    } else {
        echo '<script>alert("Error al guardar las notas.");</script>';
    }

    $stmt->close();
    exit();
}

$query = "SELECT notas FROM citas WHERE ID_citas = ?";
$stmt = $conectar->prepare($query);
$stmt->bind_param('i', $cita_id);
$stmt->execute();
$resultado = $stmt->get_result();
$cita = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Notas</title>
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
      color: #555;
    }

    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      resize: vertical;
      font-size: 16px;
      background: #f9f9f9;
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

    .btn-save {
      background-color: #28a745;
      color: white;
      border: none;
    }

    .btn-save:hover {
      background-color: #218838;
    }

    .btn-back {
      background-color: #6c757d;
      color: white;
      border: none;
    }

    .btn-back:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h1>Agregar Notas a la Cita</h1>

    <form action="" method="POST">
      <div class="form-group">
        <label for="notas">Notas:</label>
        <textarea id="notas" name="notas" rows="5"><?php echo htmlspecialchars($cita['notas'] ?? ''); ?></textarea>
      </div>

      <div class="btn-container">
        <button type="submit" class="btn btn-save">Guardar Notas</button>
        <a href="ver_cita.php?id=<?php echo $cita_id; ?>" class="btn btn-back">Regresar</a>
      </div>
    </form>
  </div>
</body>
</html>

<?php
$stmt->close();
$conectar->close();
?>
