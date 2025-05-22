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
    <h1>Editar Citas Médicas</h1>

    <a class="btn-submit" href="dashboard_citas.php">Regresar</a>
    <br>
    
    <form action="Actualizar_citas.php" method="post">


    <!-- Input hidden para el ID de la cita -->
    <input type="hidden" name="cita_id" value="<?php    echo $_GET['id']; ?>">

      <!-- Datos de la Cita -->
    <div class="form-group">
      <label>Buscar paciente:</label>
      <input class="form-group" type="text" id="buscar_paciente" placeholder="Escribe apellido o nombre..." autocomplete="off" required>
  
     <!-- Este input hidden guarda el ID del paciente -->
      <input type="hidden" name="paciente" id="id_paciente">

    <!-- Lista desplegable de sugerencias tipo select -->
      <select id="sugerencias" size="5" style="display: none; width: 100%; margin-top: 5px;"></select>

      <div class="form-group">
        <label>CURP:</label>
        <input class="form-group" type="text" name="curp" id="curp_paciente" readonly required>
      </div>
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
        <label>Especialidad:</label>
        <select name="especialidad" required>
          <option value="">Seleccione...</option>
          <?php
            include "utils/conexion.php";
            $ver_especialidad = "SELECT * FROM especialidad";
            $resultado = mysqli_query($conectar, $ver_especialidad);
            ;
            while ($fila = $resultado->fetch_assoc()){
                ?>
                    <option value="<?php echo $fila["id_especialidad"];?>">
                    <?php echo $fila["nombre_especialidad"];?>
                </option>
                <?php
            }
            mysqli_free_result($resultado)
            ?>
        </select>
      </div>

      <div class="form-group">
        <label>Médico Asignado:</label>
        <select name="medico" required>
          <option value="">Seleccione...</option>
          <?php
            //include "utils/conexion.php";
            $ver_medico = "SELECT * FROM medicos";
            $resultado = mysqli_query($conectar, $ver_medico);
            ;
            while ($fila = $resultado->fetch_assoc()){
                ?>
                    <option value="<?php echo $fila["id_medicos"];?>">
                    <?php echo $fila["nombre_medico"];?>
                </option>
                <?php
            }
            mysqli_free_result($resultado)
            ?>
        </select>
      </div>
    </div>
    <button class="btn-submit">Actulizar Cita</button>
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
<!--script para que el usuario solo pueda seleccionar cierto rango de hora-->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const horaInput = document.querySelector('input[name="hora_cita"]');

    horaInput.addEventListener("change", function () {
      const horaSeleccionada = this.value;

      if (!horaSeleccionada || horaSeleccionada.length !== 5) {
        return; // No hacemos nada si aún no está el valor completo (HH:MM)
      }

      const [hora, minuto] = horaSeleccionada.split(":").map(Number);

      // Validar rango de hora permitido
      if (
        hora < 7 ||
        (hora > 15) ||
        (hora === 15 && minuto > 0)
      ) {
        alert("Por favor selecciona una hora entre 7:00 AM y 3:00 PM.");
        this.value = "";
        return;
      }

      // Validar solo minutos 00 o 30
      if (minuto !== 0 && minuto !== 30) {
        alert("Solo puedes seleccionar horas en punto o en media hora (:00 o :30).");
        this.value = "";
      }
    });

    // Establecer pasos de 30 minutos automáticamente
    horaInput.setAttribute('step', '1800'); // 1800 segundos = 30 minutos
  });
</script>


<!--Script para que el usuario no agende citas en fechas ya pasadas ni fines de semana-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fechaCitaInput = document.querySelector('input[name="fecha_cita"]');

    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const fechaActual = ${year}-${month}-${day};

    // Bloquear fechas pasadas
    fechaCitaInput.setAttribute('min', fechaActual);

    // Validar que no elijan sábado o domingo
    fechaCitaInput.addEventListener('change', function() {
      const fechaSeleccionada = this.value;
      if (fechaSeleccionada) {
        const partes = fechaSeleccionada.split('-'); // YYYY-MM-DD
        const anio = parseInt(partes[0], 10);
        const mes = parseInt(partes[1], 10) - 1; // Mes empieza en 0 en JS
        const dia = parseInt(partes[2], 10);

        const fecha = new Date(anio, mes, dia);
        const diaSemana = fecha.getDay(); // 0=Domingo, 6=Sábado

        if (diaSemana === 0 || diaSemana === 6) {
          alert('No se permiten citas los sábados ni domingos.');
          this.value = ''; // Borrar la fecha seleccionada
        }
      }
    });
  });
</script>
<!--Script para el buscador dinamico-->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const buscarInput = document.getElementById('buscar_paciente');
  const sugerenciasDiv = document.getElementById('sugerencias');
  const idPacienteInput = document.getElementById('id_paciente');
  const curpPacienteInput = document.getElementById('curp_paciente');

  buscarInput.addEventListener('input', function() {
    const query = this.value.trim();

    if (query.length > 0) {
      fetch('buscar_pacientes.php?q=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
          sugerenciasDiv.innerHTML = '';
          if (data.length > 0) {
            sugerenciasDiv.style.display = 'block';
            data.forEach(paciente => {
              const item = document.createElement('div');
              item.style.padding = '5px';
              item.style.cursor = 'pointer';
              item.textContent = ${paciente.apellido} ${paciente.nombre};

              item.addEventListener('click', function() {
                buscarInput.value = ${paciente.apellido} ${paciente.nombre};
                idPacienteInput.value = paciente.id_pacientes;
                curpPacienteInput.value = paciente.curp;
                sugerenciasDiv.style.display = 'none';
              });

              sugerenciasDiv.appendChild(item);
            });
          } else {
            sugerenciasDiv.style.display = 'none';
          }
        })
        .catch(error => {
          console.error('Error al buscar paciente:', error);
        });
    } else {
      sugerenciasDiv.style.display = 'none';
    }
  });

  // Si el usuario hace click fuera del input o sugerencias, esconder el menú
  document.addEventListener('click', function(e) {
    if (!buscarInput.contains(e.target) && !sugerenciasDiv.contains(e.target)) {
      sugerenciasDiv.style.display = 'none';
    }
  });
});
</script>
<!--script de quien sabe para que sirve-->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const buscarPaciente = document.getElementById('buscar_paciente');
    const sugerencias = document.getElementById('sugerencias');
    const idPaciente = document.getElementById('id_paciente');
    const curpPaciente = document.getElementById('curp_paciente');

    buscarPaciente.addEventListener('input', function() {
        const query = this.value.trim();

        if (query.length === 0) {
            sugerencias.style.display = 'none';
            sugerencias.innerHTML = '';
            return;
        }

        // Buscar pacientes en el servidor
        fetch('buscar_pacientes.php?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                sugerencias.innerHTML = '';

                if (data.length > 0) {
                    sugerencias.style.display = 'block';

                    data.forEach(paciente => {
                        const option = document.createElement('option');
                        option.value = paciente.id_pacientes;
                        option.textContent = paciente.apellido + " " + paciente.nombre;
                        option.dataset.curp = paciente.curp; // guardamos el CURP como atributo
                        sugerencias.appendChild(option);
                    });
                } else {
                    sugerencias.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    sugerencias.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption) {
            buscarPaciente.value = selectedOption.textContent;
            idPaciente.value = selectedOption.value;
            curpPaciente.value = selectedOption.dataset.curp;
            sugerencias.style.display = 'none'; // ocultar después de seleccionar
        }
    });
});
</script>
</body>
</html>