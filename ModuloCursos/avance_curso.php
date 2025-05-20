<?php
$curso_id = $_GET['curso_id'] ?? null;


$empleado_id = $_GET['empleado_id'] ?? null;

if (!$curso_id || !$empleado_id) {
    echo "Acceso inválido.";
    exit;
}

$conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Validar que el empleado está inscrito en el curso (seguridad)
$stmt = $conexion->prepare("SELECT * FROM registro WHERE id_curso = ? AND id_empleado = ?");
$stmt->bind_param("ii", $curso_id, $empleado_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No tienes acceso a este curso.";
    exit;
}
$stmt->close();

// Obtener info del curso
$stmt2 = $conexion->prepare("SELECT titulo, descripcion FROM cursos WHERE curso_id = ?");
$stmt2->bind_param("i", $curso_id);
$stmt2->execute();
$curso_info = $stmt2->get_result()->fetch_assoc();
$stmt2->close();

// Obtener módulos del curso ordenados por orden
$sql_modulos = "SELECT id, titulo FROM modulos WHERE id_curso = ? ORDER BY orden";
$stmt3 = $conexion->prepare($sql_modulos);
$stmt3->bind_param("i", $curso_id);
$stmt3->execute();
$modulos = $stmt3->get_result();
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Avance del Curso: <?php echo htmlspecialchars($curso_info['titulo']); ?></title>
    <link rel="stylesheet" href="avance.css">
</head>

<body>
    <div class="tarjeta"> <!-- INICIO DE LA TARJETA -->

        <h1><?php echo htmlspecialchars($curso_info['titulo']); ?></h1>
        <p><?php echo htmlspecialchars($curso_info['descripcion']); ?></p>

        <?php if ($modulos->num_rows > 0): ?>
            <h2>Temario</h2>
            <ul>
                <?php while ($modulo = $modulos->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($modulo['titulo']); ?></strong>
                        <ul>
                            <?php
                            $sql_lecciones = "SELECT id, titulo FROM lecciones WHERE id_modulo = ? ORDER BY orden";
                            $stmt4 = $conexion->prepare($sql_lecciones);
                            $stmt4->bind_param("i", $modulo['id']);
                            $stmt4->execute();
                            $lecciones = $stmt4->get_result();

                            while ($leccion = $lecciones->fetch_assoc()): ?>
                                <li>
                                    <a href="leccion.php?id=<?php echo $leccion['id']; ?>&curso_id=<?php echo $curso_id; ?>&empleado_id=<?php echo $empleado_id; ?>">
                                        <?php echo htmlspecialchars($leccion['titulo']); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                            <?php $stmt4->close(); ?>
                        </ul>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Este curso no tiene módulos aún.</p>
        <?php endif; ?>

        <!-- Botón para volver -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="Cursos_Virtuales.php">
                <button style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Volver a mis cursos</button>
            </a>
        </div>

    </div> <!-- FIN DE LA TARJETA -->
</body>






</html>

<?php
$stmt3->close();
$conexion->close();
?>