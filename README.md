# sistema de gestión de citas médicas

## descripción
desarrollo de un sistema web para la gestión de citas médicas en clínicas y hospitales. permite a los pacientes agendar, modificar y cancelar citas, así como recibir notificaciones de recordatorio. los médicos pueden administrar sus horarios y registrar notas sobre las consultas.

## características principales
- registro y autenticación de pacientes y médicos.
- agenda dinámica con disponibilidad de turnos en tiempo real.
- notificaciones automáticas vía correo.
- generación de reportes de citas y estadísticas de ocupación.
- administración de horarios médicos.
- gestión de notas de consulta.

## estructura de la base de datos
la base de datos incluye las siguientes tablas:
- `usuarios`: almacena información de los usuarios del sistema (administrativos, médicos y pacientes).
- `medicos`: información específica de los médicos.
- `pacientes`: datos de los pacientes registrados.
- `horarios`: horario laboral de los médicos.
- `citas`: gestiona la programación de citas médicas.
- `notas_consulta`: almacena diagnósticos, tratamientos y observaciones de las consultas.
- `notificaciones`: registro de notificaciones enviadas a los usuarios.
- `reportes`: generación de reportes con relación a los médicos.

## instalación
a continuación, se detallan los pasos para instalar y configurar el sistema:
1. clonar el repositorio.
2. configurar la base de datos ejecutando las sentencias sql proporcionadas.
3. configurar las credenciales de conexión a la base de datos en el archivo de configuración.
4. ejecutar el servidor backend.
5. Abrir la carpeta en el navegador

## tecnologías utilizadas
- mysql (gestión de base de datos).
- php  (backend).



