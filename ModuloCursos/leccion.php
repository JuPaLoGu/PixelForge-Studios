<?php
$id_leccion = $_GET['id'] ?? null;
$empleado_id = $_GET['empleado_id'] ?? null;

if (!$id_leccion || !$empleado_id) {
    echo "Acceso inválido.";
    exit;
}

$conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener datos completos de la lección
$stmt = $conexion->prepare("SELECT * FROM lecciones WHERE id = ?");
$stmt->bind_param("i", $id_leccion);
$stmt->execute();
$leccion = $stmt->get_result()->fetch_assoc();
if (!$leccion) {
    echo "Lección no encontrada.";
    exit;
}

// Obtener orden e id_curso del módulo
$stmt_mod = $conexion->prepare("SELECT id, orden, id_curso FROM modulos WHERE id = ?");
$stmt_mod->bind_param("i", $leccion['id_modulo']);
$stmt_mod->execute();
$modulo_info = $stmt_mod->get_result()->fetch_assoc();

$id_modulo_actual = $modulo_info['id'];
$modulo_actual = $modulo_info['orden'];
$id_curso = $modulo_info['id_curso'];

// Verificar inscripción
$stmt2 = $conexion->prepare("SELECT * FROM registro WHERE id_curso = ? AND id_empleado = ?");
$stmt2->bind_param("ii", $id_curso, $empleado_id);
$stmt2->execute();
$result = $stmt2->get_result();

if ($result->num_rows === 0) {
    echo "No estás inscrito en este curso.";
    exit;
}

// Bloquear si no ha aprobado el módulo anterior
if ($modulo_actual > 1) {
    $modulo_anterior = $modulo_actual - 1;
    $stmt3 = $conexion->prepare("SELECT id FROM modulos WHERE id_curso = ? AND orden = ?");
    $stmt3->bind_param("ii", $id_curso, $modulo_anterior);
    $stmt3->execute();
    $modulo_anterior_data = $stmt3->get_result()->fetch_assoc();

    if ($modulo_anterior_data) {
        $id_modulo_anterior = $modulo_anterior_data['id'];
       $stmt4 = $conexion->prepare("SELECT aprobado FROM examenes WHERE id_modulo = ? AND empleado_id = ? AND aprobado = 1");
        $stmt4->bind_param("ii", $id_modulo_anterior, $empleado_id);
        $stmt4->execute();
        $res_examen = $stmt4->get_result();

        if ($res_examen->num_rows === 0) {
            echo "<h2>Acceso bloqueado</h2><p>Debes aprobar el módulo anterior antes de acceder a esta lección.</p>";
            exit;
        }
    }
}

// Verificar si aprobó el módulo actual
$stmt5 = $conexion->prepare("SELECT aprobado FROM examenes WHERE id_modulo = ? AND empleado_id = ? AND aprobado = 1");
$stmt5->bind_param("ii", $id_modulo_actual, $empleado_id);
$stmt5->execute();
$res_aprobado = $stmt5->get_result();
$modulo_aprobado = $res_aprobado->num_rows > 0;

// Obtener siguiente lección
$stmt6 = $conexion->prepare("
    SELECT l.id, l.titulo
    FROM lecciones l
    JOIN modulos m ON l.id_modulo = m.id
    WHERE m.id_curso = ? AND (
        m.orden > ? OR (m.orden = ? AND l.orden > ?)
    )
    ORDER BY m.orden ASC, l.orden ASC
    LIMIT 1
");
$stmt6->bind_param("iiii", $id_curso, $modulo_actual, $modulo_actual, $leccion['orden']);
$stmt6->execute();
$res_next = $stmt6->get_result();
$siguiente_leccion = $res_next->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($leccion['titulo']); ?></title>
    <link rel="stylesheet" href="leccion.css">
</head>
<body>
    <h2><?php echo htmlspecialchars($leccion['titulo']); ?></h2>
    <p><strong>Contenido:</strong> <?php echo nl2br(htmlspecialchars($leccion['contenido'])); ?></p>

    <?php if (!empty($leccion['video_url'])): ?>
        <h3>Videos</h3>
        <?php
        $videos = explode(',', $leccion['video_url']);
        foreach ($videos as $url):
            $url = trim($url);
            if (preg_match('/(?:youtube\\.com\\/watch\\?v=|youtu\\.be\\/)([^\\s&]+)/', $url, $match)) {
                $youtube_id = $match[1];
        ?>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allowfullscreen></iframe><br><br>
        <?php
            } else {
                echo "<a href='" . htmlspecialchars($url) . "' target='_blank'>" . htmlspecialchars($url) . "</a><br>";
            }
        endforeach;
        ?>
    <?php endif; ?>

    <?php if (!empty($leccion['doc_url'])): ?>
        <h3>Documentos</h3>
        <?php
        $docs = explode(',', $leccion['doc_url']);
        foreach ($docs as $doc) {
            $doc = trim($doc);
            if (!empty($doc)) {
                echo "<p><a href='" . htmlspecialchars($doc) . "' target='_blank'>📄 Ver documento</a></p>";
            }
        }
        ?>
    <?php endif; ?>

    <form action="quiz.php" method="GET">
        <input type="hidden" name="id_modulo" value="<?php echo $leccion['id_modulo']; ?>">
        <input type="hidden" name="empleado_id" value="<?php echo $empleado_id; ?>">
        <button type="submit">Realizar Quiz del Módulo</button>
    </form>

    <?php if ($siguiente_leccion): ?>
        <?php if ($modulo_aprobado): ?>
            <form action="leccion.php" method="GET">
                <input type="hidden" name="id" value="<?php echo $siguiente_leccion['id']; ?>">
                <input type="hidden" name="empleado_id" value="<?php echo $empleado_id; ?>">
                <button type="submit">➡️ Siguiente lección: <?php echo htmlspecialchars($siguiente_leccion['titulo']); ?></button>
            </form>
        <?php else: ?>
            <p><strong>🔒 Debes aprobar el quiz del módulo actual para acceder a la siguiente lección.</strong></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

<?php
$stmt->close();
$stmt2->close();
$conexion->close();
?>

