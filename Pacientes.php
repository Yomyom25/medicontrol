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
    <h1>Formulario de pacientes</h1>

    <form action="guardar_paciente.php" method="post">
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
        <input type="text" name="curp" required>
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

    <button class="btn-submit">Agregar paciente</button>
    </form>
  </div>

  <!--Parte de los Scrips del codigo-->
  <!--Este Scrips hace que en input de curp no agregues mas de 18 caracteres y menos de 18-->
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    let curpInput = document.querySelector('input[name="curp"]');

    curpInput.addEventListener("input", function() {
      if (curpInput.value.length > 18) {
        curpInput.value = curpInput.value.slice(0, 18); // Corta si es mayor a 18
      }
    });

    document.querySelector("form").addEventListener("submit", function(event) {
      if (curpInput.value.length !== 18) {
        alert("El CURP debe tener exactamente 18 caracteres.");
        event.preventDefault(); // Evita el envío del formulario
      }
    });
  });
</script>
<!--El siguiente scrip es para verificar que todos los campos esten llenos y que no quede uno sin llenar-->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    let form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
      let inputs = form.querySelectorAll("input, select");
      let isValid = true;

      inputs.forEach(input => {
        let errorLabel = input.nextElementSibling; // Busca el label de error junto al input
        
        // Si no existe el label, lo crea
        if (!errorLabel || !errorLabel.classList.contains("error-label")) {
          errorLabel = document.createElement("label");
          errorLabel.classList.add("error-label");
          input.parentNode.appendChild(errorLabel);
        }

        // Verifica si el campo está vacío
        if (input.value.trim() === "") {
          errorLabel.textContent = "Este campo es obligatorio.";
          errorLabel.style.display = "inline"; // Muestra el mensaje
          isValid = false;
        } else {
          errorLabel.style.display = "none"; // Oculta el mensaje si el campo está lleno
        }
      });

      if (!isValid) {
        event.preventDefault(); // Evita que el formulario se envíe si hay errores
      }
    });
  });
</script>
</body>
</html>