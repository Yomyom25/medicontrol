<?php
require('fpdf/fpdf.php');
require('conexion.php'); // Conexión a la base de datos

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('img/hospital-icon.png', 10, 6, 30); // Ajusta el logo según sea necesario
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('Reporte de Cita Médica'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, utf8_decode('Pág. ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, date('d-m-Y'), 0, 0, 'R');
    }

    function FancyTable($header, $data)
    {
        // Colores
        $this->SetFillColor(0, 102, 204); // Azul oscuro
        $this->SetTextColor(255);
        $this->SetDrawColor(255, 255, 255);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 10);

        // Cabecera
        $w = [60, 120]; // Anchos de las columnas
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        $this->Ln();

        // Restaurar colores y fuente
        $this->SetFillColor(245, 245, 245); // Gris claro
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 9);

        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, utf8_decode($row[0]), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, utf8_decode($row[1]), 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill; // Alternar color de fondo
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Obtener el ID de la cita desde la URL
$cita_id = $_GET['id'] ?? 0;

// Consulta a la base de datos para obtener la información de la cita
$sql = "
    SELECT 
        c.ID_citas, c.fecha, c.hora, c.estatus, c.notas, 
        p.nombre AS nombre_paciente, p.apellido AS apellido_paciente, p.curp, p.sexo, p.fecha_nacimiento,
        m.nombre AS nombre_medico, m.cedula, m.email AS email_medico, m.tel_contacto,
        e.nombre_especialidad
    FROM citas c
    INNER JOIN pacientes p ON c.paciente = p.ID_paciente
    INNER JOIN medicos m ON c.medico = m.ID_medico
    INNER JOIN especialidades e ON m.especialidad = e.ID_especialidad
    WHERE c.ID_citas = ?
";

$stmt = $conectar->prepare($sql);
$stmt->bind_param('i', $cita_id);
$stmt->execute();
$resultado = $stmt->get_result();
$cita = $resultado->fetch_assoc();

if (!$cita) {
    echo '<script>alert("Cita no encontrada."); location.href = "dashboard_citas.php";</script>';
    exit();
}

// Preparar datos para el PDF
$data = [
    ['ID Cita:', $cita['ID_citas']],
    ['Fecha:', $cita['fecha']],
    ['Hora:', $cita['hora']],
    ['Estado:', ($cita['estatus'] == 'R') ? 'Realizada' : 'Pendiente'],
    ['Notas:', $cita['notas']],
    ['Paciente:', $cita['apellido_paciente'] . ' ' . $cita['nombre_paciente']],
    ['CURP:', $cita['curp']],
    ['Sexo:', ($cita['sexo'] == 'M') ? 'Masculino' : 'Femenino'],
    ['Fecha de Nacimiento:', $cita['fecha_nacimiento']],
    ['Médico:', $cita['nombre_medico']],
    ['Cédula:', $cita['cedula']],
    ['Email Médico:', $cita['email_medico']],
    ['Teléfono Médico:', $cita['tel_contacto']],
    ['Especialidad:', $cita['nombre_especialidad']],
];

// Generar PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->FancyTable(['Campo', 'Información'], $data);
$pdf->Output();
?>
