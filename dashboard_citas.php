dashboard_citas.php

<?php include 'header.php';?>
<?php include 'barra_lateral.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard de Citas Médicas</title>
  <link rel="stylesheet" href="css/principal.css">
  <style>
    .contenedor {
  margin: 0 auto;
  margin-top: 50px;
  padding: 20px;
  max-width: 800px; /* Ajusta el ancho máximo para que tenga más espacio */
}

.btn-create {
  background-color: #6200ea;
  color: #fff;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
  margin-bottom: 20px;
  display: inline-block;
}

.btn-create:hover {
  background-color: #4500b5;
}

.table-container {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

table {
  width: 100%;
  padding: 5px;
  border-collapse: collapse;
  margin-bottom: 20px;
}

th, td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f4f4f9;
  font-weight: bold;
}

.actions, .edit, .delete {
  text-align: center;
}

.actions a, .edit a, .delete a {
  color: #6200ea;
  text-decoration: none;
  padding: 5px 10px;
  border-radius: 5px;
  border: 1px solid #6200ea;
  transition: background-color 0.3s, color 0.3s;
}

.actions a:hover, .edit a:hover, .delete a:hover {
  background-color: #6200ea;
  color: #fff;
}

  </style>
</head>
<body>
  <div class="contenedor">
    <h1>Dashboard de Citas Médicas</h1>

    <a href="citas.php" class="btn-submit">Crear Nueva Cita</a>

    <br>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nombre del Paciente</th>
            <th>Médico Asignado</th>
            <th>Fecha de la Cita</th>
            <th>Ver</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            require "conexion.php";

            $todos = "SELECT * FROM citas INNER JOIN pacientes ON apellido_paciente = id_pacientes INNER JOIN medicos ON medico = id_medicos ORDER BY id_citas ASC";
            $resultado = mysqli_query($conectar, $todos);

            while ($fila = $resultado->fetch_array()){
            ?>
          <tr>
            <td><?php echo $fila["nombre"]; ?></td>
            <td><?php echo $fila["nombre_medico"]; ?></td>
            <td><?php echo $fila["fecha"]; ?></td>  
            <td class="actions"><a href="#">Ver</a></td>
            <td class="edit"><a href="editar_cita.php?id=<?php echo $fila['id_citas'];?>">Editar</a></td>
            <td class="delete"><a href="#">Eliminar</a></td>
          </tr>
          <?php
            }
            mysqli_free_result($resultado)
            ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>