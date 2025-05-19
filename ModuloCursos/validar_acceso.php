<?php
$curso_id = $_GET['curso_id'] ?? null;

if (!$curso_id) {
    echo "Curso no especificado.";
    exit;
}

// Procesar formulario si fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';

    $conexion = new mysqli("localhost", "root", "", "pixelforgestudios1");
    $conexion->set_charset("utf8");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Buscar ID del empleado por correo
    $stmt = $conexion->prepare("SELECT id FROM empleados WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $empleado = $resultado->fetch_assoc();
        $empleado_id = $empleado['id'];

        // Verificar si está inscrito en el curso
        $stmt2 = $conexion->prepare("SELECT * FROM registro WHERE id_curso = ? AND id_empleado = ?");
        $stmt2->bind_param("ii", $curso_id, $empleado_id);
        $stmt2->execute();
        $resultado2 = $stmt2->get_result();

        if ($resultado2->num_rows > 0) {
            // Está inscrito, redirigir al avance
            header("Location: avance_curso.php?curso_id=$curso_id&empleado_id=$empleado_id");
            exit;
        } else {
            $mensaje_error = "Lo sentimos, no tienes acceso a este contenido hasta estar registrado.";
        }

        $stmt2->close();
    } else {
        $mensaje_error = "Correo no encontrado.";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar acceso</title>
    <link rel="stylesheet" href="acceso.css">
</head>
<body>
    <div class="formulario-validacion">
        <h2>Validar acceso al curso</h2>
        <?php if (isset($mensaje_error)) echo "<p style='color: red;'>$mensaje_error</p>"; ?>
        <form method="post">
            <label for="correo">Ingresa tu correo electrónico:</label><br>
            <input type="email" name="correo" required><br><br>
            <input type="submit" value="Ver avance">
        </form>
    </div>
</body>
</html>
