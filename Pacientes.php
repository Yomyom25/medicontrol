<?php include 'header.php'; ?>
<?php include 'barra_lateral.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Paciente</title>
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

    .form-box {
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    label span.asterisk {
      color: red;
      margin-left: 5px;
    }

    input, select, button {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border-radius: 5px;
      border: 1px solid #ddd;
    }

    button.btn-submit {
      background-color: #6200ea;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
    }

    button.btn-submit:hover {
      background-color: #4500b5;
    }

    .error-label {
      color: red;
      font-size: 12px;
      display: none;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h1>Formulario de Pacientes</h1>

    <form action="guardar_paciente.php" method="post" novalidate>
      <!-- Datos del Paciente -->
      <div class="form-box">
        <h2>Datos del Paciente</h2>
        <div class="form-group">
          <label>Nombre:<span class="asterisk">*</span></label>
          <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
          <label>Apellido:<span class="asterisk">*</span></label>
          <input type="text" name="apellido" required>
        </div>
        <div class="form-group">
          <label>CURP:<span class="asterisk">*</span></label>
          <input type="text" name="curp" maxlength="18" pattern="[A-Z0-9]{18}" title="El CURP debe tener exactamente 18 caracteres alfanuméricos." required>
        </div>
        <div class="form-group">
          <label>Sexo:<span class="asterisk">*</span></label>
          <select name="sexo" required>
            <option value="">Seleccione...</option>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
          </select>
        </div>
        <div class="form-group">
          <label>Fecha de Nacimiento:<span class="asterisk">*</span></label>
          <input type="date" name="fecha_nacimiento" required>
        </div>
      </div>

      <button class="btn-submit">Agregar Paciente</button>
    </form>
  </div>

  <!-- Scripts para validaciones -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Validar longitud del CURP
      const curpInput = document.querySelector('input[name="curp"]');
      curpInput.addEventListener("input", function() {
        if (curpInput.value.length > 18) {
          curpInput.value = curpInput.value.slice(0, 18);
        }
      });

      // Validación general del formulario
      const form = document.querySelector("form");
      form.addEventListener("submit", function(event) {
        let isValid = true;

        form.querySelectorAll("input, select").forEach(input => {
          const errorLabel = input.nextElementSibling;

          if (input.value.trim() === "") {
            if (!errorLabel) {
              const newError = document.createElement("label");
              newError.classList.add("error-label");
              newError.textContent = "Este campo es obligatorio.";
              input.parentNode.appendChild(newError);
            } else {
              errorLabel.textContent = "Este campo es obligatorio.";
              errorLabel.style.display = "inline";
            }
            isValid = false;
          } else if (errorLabel) {
            errorLabel.style.display = "none";
          }
        });

        if (!isValid) {
          event.preventDefault();
          alert("Por favor complete todos los campos correctamente.");
        }
      });
    });
  </script>
</body>
</html>
