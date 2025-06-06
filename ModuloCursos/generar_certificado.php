<?php
// Definir la ruta de las fuentes antes de incluir FPDF
define('FPDF_FONTPATH', __DIR__ . '/fpdf/font/');

require('fpdf/fpdf.php'); // Asegúrate de tener la librería FPDF en esa carpeta

$conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
$conexion->set_charset("utf8");

$empleado_id = $_GET['empleado_id'] ?? null;
$curso_id = $_GET['curso_id'] ?? null;

if (!$empleado_id || !$curso_id) {
    die("Parámetros inválidos.");
}

// Verificar que el curso fue completado con todos los módulos aprobados
$stmt = $conexion->prepare("
    SELECT 
        (SELECT COUNT(*) FROM modulos WHERE id_curso = ?) AS total_modulos,
        (SELECT COUNT(*) FROM examenes WHERE id_curso = ? AND empleado_id = ? AND aprobado = 1) AS modulos_aprobados
");
$stmt->bind_param("iii", $curso_id, $curso_id, $empleado_id);
$stmt->execute();
$datos = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($datos['total_modulos'] != $datos['modulos_aprobados']) {
    die("Aún no ha completado todos los módulos requeridos.");
}

<<<<<<< HEAD

// Obtener nombre del empleado y del curso

// MODIFICACIÓN: Se usa un JOIN con la tabla 'users' para obtener el nombre
$stmt_empleado = $conexion->prepare("SELECT u.username FROM empleados e JOIN users u ON e.usuario_id = u.id WHERE e.empleado_id = ?");
$stmt_empleado->bind_param("i", $empleado_id);
$stmt_empleado->execute();
$empleado_data = $stmt_empleado->get_result()->fetch_assoc();
$stmt_empleado->close(); // <-- Asegúrate de que este punto y coma esté aquí.

// Obtener el título del curso (esta línea ya deberías tenerla más abajo o agrégala si no)
$curso = $conexion->query("SELECT titulo FROM cursos WHERE curso_id = $curso_id")->fetch_assoc();

// Asegúrate de que $empleado_data no sea null antes de intentar acceder a 'username'
if ($empleado_data && isset($empleado_data['username'])) {
    $nombre_empleado = $empleado_data['username']; // Asigna el nombre del usuario a esta variable
} else {
    $nombre_empleado = "Empleado Desconocido"; // Valor por defecto si no se encuentra el nombre
}

$titulo_curso = $curso['titulo']; // Asigna el título del curso a esta variable
$fecha = date("d/m/Y"); // Asigna la fecha actual a esta variable

// Crear el certificado PDF
class PDF extends FPDF
{
    function Header()
    {
=======
// Obtener nombre del empleado y del curso
$empleado = $conexion->query("SELECT nombre FROM empleados WHERE empleado_id = $empleado_id")->fetch_assoc();
$curso = $conexion->query("SELECT titulo FROM cursos WHERE curso_id = $curso_id")->fetch_assoc();

$nombre_empleado = $empleado['nombre'];
$titulo_curso = $curso['titulo'];
$fecha = date("d/m/Y");

// Crear el certificado PDF
class PDF extends FPDF {
    function Header() {
>>>>>>> origin/Jaime_Novoa
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('PIXEL FORGE STUDIO'), 0, 1, 'C');
        $this->Ln(10);
    }

<<<<<<< HEAD
    function Footer()
    {
=======
    function Footer() {
>>>>>>> origin/Jaime_Novoa
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, utf8_decode('Certificado generado automáticamente'), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 14);

$pdf->Ln(20);
$pdf->Cell(0, 10, utf8_decode("CERTIFICADO DE FINALIZACIÓN"), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, utf8_decode("Se certifica que el estudiante $nombre_empleado ha completado satisfactoriamente todos los módulos del curso \"$titulo_curso\" con un desempeño aprobado."), 0, 'C');
$pdf->Ln(20);

$pdf->Cell(0, 10, utf8_decode("Fecha de emisión: $fecha"), 0, 1, 'C');
$pdf->Ln(30);
$pdf->Cell(0, 10, utf8_decode("_________________________"), 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode("Firma del Instructor"), 0, 1, 'C');

// Descargar el PDF
$pdf->Output("I", "certificado_$nombre_empleado.pdf");
<<<<<<< HEAD
=======
?>
>>>>>>> origin/Jaime_Novoa
