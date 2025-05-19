<?php
$conexion = new mysqli("localhost", "root", "", "pixelforgestudios1");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $curso_id = $_POST['curso_id'] ?? null;
    $empleado_id = $_POST['empleado_id'] ?? null;

    if (!$curso_id || !$empleado_id) {
        die("Faltan datos obligatorios.");
    }

    // Insertar registro
    $stmt = $conexion->prepare("INSERT INTO registro_curso (curso_id, empleado_id, fecha_inscripcion) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $curso_id, $empleado_id);

    if ($stmt->execute()) {
        echo "Inscripción exitosa al curso.";
    } else {
        echo "Error al registrar: " . $conexion->error;
    }
} else {
    echo "Acceso no permitido.";
}
