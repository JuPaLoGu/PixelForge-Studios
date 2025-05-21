<?php
// registro_curso.php

$conexion = new mysqli("localhost", "root", "", "pixelforgestudios1");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');

    // Buscar empleado por nombre y apellido
    $stmt = $conexion->prepare("SELECT id FROM empleados WHERE nombre = ? AND apellido = ?");
    $stmt->bind_param("ss", $nombre, $apellido);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $empleado = $resultado->fetch_assoc();
        $id_empleado = $empleado['id'];

        // Verificar que exista el curso
        $stmt2 = $conexion->prepare("SELECT id FROM cursos WHERE id = ?");
        $stmt2->bind_param("i", $curso_id);
        $stmt2->execute();
        $res_curso = $stmt2->get_result();

        if ($res_curso && $res_curso->num_rows > 0) {
            // Insertar inscripción
            $stmt3 = $conexion->prepare("INSERT INTO registro_cursos (id_curso, id_empleado, fecha_inscripcion) VALUES (?, ?, CURDATE())");
            $stmt3->bind_param("ii", $curso_id, $id_empleado);
            if ($stmt3->execute()) {
                echo "<p>¡Inscripción registrada correctamente!</p>";
            } else {
                echo "<p>Error al registrar la inscripción.</p>";
            }
            $stmt3->close();
        } else {
            echo "<p>Curso no encontrado.</p>";
        }
        $stmt2->close();
    } else {
        echo "<p>Empleado no registrado. Verifica el nombre y apellido.</p>";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!-- Formulario -->
<form method="post" action="">
    <h2>Formulario de inscripción a curso</h2>
    <input type="hidden" name="curso_id" value="<?= htmlspecialchars($curso_id) ?>">

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" required><br>

    <label for="apellido">Apellido:</label><br>
    <input type="text" name="apellido" id="apellido" required><br><br>

    <button type="submit">Inscribirse</button>
</form>
