<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
$conexion->set_charset("utf8");

$id_modulo = $_GET['id_modulo'] ?? null;
$empleado_id = $_GET['empleado_id'] ?? null;

if (!$id_modulo || !$empleado_id) {
    echo "Acceso inválido.";
    exit;
}

$resultado_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuestas = $_POST['respuesta'] ?? [];

    $stmt = $conexion->prepare("SELECT id, respuesta_correcta FROM evaluaciones WHERE id_modulo = ?");
    $stmt->bind_param("i", $id_modulo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $total_preguntas = 0;
    $aciertos = 0;

    while ($pregunta = $resultado->fetch_assoc()) {
        $total_preguntas++;
        $id_pregunta = $pregunta['id'];
        $respuesta_correcta = $pregunta['respuesta_correcta'];

        if (isset($respuestas[$id_pregunta]) && $respuestas[$id_pregunta] === $respuesta_correcta) {
            $aciertos++;
        }
    }
    $stmt->close();

    $porcentaje = ($total_preguntas > 0) ? ($aciertos / $total_preguntas) * 100 : 0;
    $aprobado = ($porcentaje >= 75) ? 1 : 0;

    // Obtener curso relacionado al módulo
    $stmt2 = $conexion->prepare("SELECT id_curso FROM modulos WHERE id = ?");
    $stmt2->bind_param("i", $id_modulo);
    $stmt2->execute();
    $curso_data = $stmt2->get_result()->fetch_assoc();
    $id_curso = $curso_data['id_curso'];
    $stmt2->close();

    // Revisar si ya existe examen previo
    $stmt3 = $conexion->prepare("SELECT id FROM examenes WHERE id_modulo = ? AND empleado_id = ?");
    $stmt3->bind_param("ii", $id_modulo, $empleado_id);
    $stmt3->execute();
    $examen_existente = $stmt3->get_result()->fetch_assoc();
    $stmt3->close();

    if ($examen_existente) {
        $stmt4 = $conexion->prepare("UPDATE examenes SET puntaje = ?, aprobado = ? WHERE id = ?");
        $stmt4->bind_param("dii", $porcentaje, $aprobado, $examen_existente['id']);
        $stmt4->execute();
        $stmt4->close();
    } else {
<<<<<<< HEAD
        /*$stmt5 = $conexion->prepare("INSERT INTO examenes (empleado_id, id_curso, id_modulo, puntaje, aprobado) VALUES (?, ?, ?, ?, ?)");
        $stmt5->bind_param("iiiid", $empleado_id, $id_curso, $id_modulo, $porcentaje, $aprobado);*/

        // MODIFICACIÓN: Ya no se incluye 'id_curso' en el INSERT Statement
        // Se añade 'fecha_examen' a la lista de columnas y se usa 'NOW()' para la fecha actual.
        $stmt5 = $conexion->prepare("INSERT INTO examenes (empleado_id, id_modulo, puntaje, aprobado, fecha_examen) VALUES (?, ?, ?, ?, NOW())");
        
        // MODIFICACIÓN: Se quita el parámetro '$id_curso' del bind_param.
        // Los tipos de los parámetros: i (empleado_id), i (id_modulo), d (puntaje - porque es porcentaje), i (aprobado - que es 0 o 1)
        $stmt5->bind_param("iidi", $empleado_id, $id_modulo, $porcentaje, $aprobado); 
=======
        $stmt5 = $conexion->prepare("INSERT INTO examenes (empleado_id, id_curso, id_modulo, puntaje, aprobado) VALUES (?, ?, ?, ?, ?)");
        $stmt5->bind_param("iiiid", $empleado_id, $id_curso, $id_modulo, $porcentaje, $aprobado);
>>>>>>> origin/Jaime_Novoa
        $stmt5->execute();
        $stmt5->close();
    }

    // Construir mensaje con resultado
    $resultado_mensaje .= "<div style='border:2px solid " . ($aprobado ? "green" : "red") . "; padding: 10px; margin-top: 20px;'>";
    $resultado_mensaje .= "<h3>Resultado del Quiz</h3>";
    $resultado_mensaje .= "<p>Preguntas correctas: $aciertos de $total_preguntas</p>";
    $resultado_mensaje .= "<p>Porcentaje: " . round($porcentaje, 2) . "%</p>";

    if ($aprobado) {
        $resultado_mensaje .= "<p style='color:green;'>¡Felicidades! Has aprobado el módulo.</p>";

        // Verificar si hay un siguiente módulo
        $stmt_next = $conexion->prepare("SELECT id FROM modulos WHERE id_curso = ? AND id > ? ORDER BY id ASC LIMIT 1");
        $stmt_next->bind_param("ii", $id_curso, $id_modulo);
        $stmt_next->execute();
        $next_result = $stmt_next->get_result();

        if ($next_module = $next_result->fetch_assoc()) {
<<<<<<< HEAD
            $siguiente_modulo_id = $next_module['id'];
            $resultado_mensaje .= "<form method='get' action='avance_curso.php'>";
            $resultado_mensaje .= "<input type='hidden' name='curso_id' value='$id_curso'>";
            $resultado_mensaje .= "<input type='hidden' name='empleado_id' value='$empleado_id'>";
            $resultado_mensaje .= "<input type='hidden' name='modulo_desbloqueado' value='$siguiente_modulo_id'>";
            $resultado_mensaje .= "<button type='submit'>Ir al contenido del curso</button>";
            $resultado_mensaje .= "</form>";
        } else {
=======
    $siguiente_modulo_id = $next_module['id'];
     $resultado_mensaje .= "<form method='get' action='avance_curso.php'>";
$resultado_mensaje .= "<input type='hidden' name='curso_id' value='$id_curso'>";
    $resultado_mensaje .= "<input type='hidden' name='empleado_id' value='$empleado_id'>";
    $resultado_mensaje .= "<input type='hidden' name='modulo_desbloqueado' value='$siguiente_modulo_id'>";
    $resultado_mensaje .= "<button type='submit'>Ir al contenido del curso</button>";
    $resultado_mensaje .= "</form>";
}
else {
>>>>>>> origin/Jaime_Novoa
            $resultado_mensaje .= "<p style='color:blue;'>Has completado todos los módulos de este curso.</p>";
            $stmt_check = $conexion->prepare("
        SELECT 
            (SELECT COUNT(*) FROM modulos WHERE id_curso = ?) AS total_modulos,
            (SELECT COUNT(*) FROM examenes WHERE id_curso = ? AND empleado_id = ? AND aprobado = 1) AS modulos_aprobados
    ");
<<<<<<< HEAD
            $stmt_check->bind_param("iii", $id_curso, $id_curso, $empleado_id);
            $stmt_check->execute();
            $check_result = $stmt_check->get_result()->fetch_assoc();
            $stmt_check->close();

            // Si ya aprobó todos los módulos, redirigir a generar certificado
            if ($check_result['total_modulos'] == $check_result['modulos_aprobados']) {
                echo "<script>
            window.location.href = 'generar_certificado.php?curso_id=$id_curso&empleado_id=$empleado_id';
        </script>";
                exit;
            }
=======
    $stmt_check->bind_param("iii", $id_curso, $id_curso, $empleado_id);
    $stmt_check->execute();
    $check_result = $stmt_check->get_result()->fetch_assoc();
    $stmt_check->close();

    // Si ya aprobó todos los módulos, redirigir a generar certificado
    if ($check_result['total_modulos'] == $check_result['modulos_aprobados']) {
        echo "<script>
            window.location.href = 'generar_certificado.php?curso_id=$id_curso&empleado_id=$empleado_id';
        </script>";
        exit;
    }
>>>>>>> origin/Jaime_Novoa
        }

        $stmt_next->close();
    } else {
        $resultado_mensaje .= "<p style='color:red;'>No aprobaste el módulo, inténtalo nuevamente.</p>";
    }

    $resultado_mensaje .= "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<<<<<<< HEAD

<head>
    <meta charset="UTF-8">
    <title>Quiz del Módulo</title>
    <link rel="stylesheet" href="leccion.css">
</head>

=======
<head>
    <meta charset="UTF-8">
    <title>Quiz del Módulo</title>
</head>
>>>>>>> origin/Jaime_Novoa
<body>
    <h1>Evaluación del Módulo</h1>

    <form method="post">
        <?php
        $stmt = $conexion->prepare("SELECT * FROM evaluaciones WHERE id_modulo = ?");
        $stmt->bind_param("i", $id_modulo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($pregunta = $resultado->fetch_assoc()) {
            echo "<div style='margin-bottom:15px;'>";
            echo "<p><strong>" . htmlspecialchars($pregunta['pregunta']) . "</strong></p>";


<<<<<<< HEAD
            $letras = ['a', 'b', 'c', 'd'];
            foreach ($letras as $letra) {
                $campo_opcion = 'opcion_' . $letra;
                if (!empty($pregunta[$campo_opcion])) {
                    echo "<label>";
                    echo "<input type='radio' name='respuesta[{$pregunta['id']}]' value='$letra'> ";
                    echo htmlspecialchars($pregunta[$campo_opcion]);
                    echo "</label><br>";
                }
            }
=======
          $letras = ['a', 'b', 'c', 'd'];
foreach ($letras as $letra) {
    $campo_opcion = 'opcion_' . $letra;
    if (!empty($pregunta[$campo_opcion])) {
        echo "<label>";
        echo "<input type='radio' name='respuesta[{$pregunta['id']}]' value='$letra'> ";
        echo htmlspecialchars($pregunta[$campo_opcion]);
        echo "</label><br>";
    }
}
>>>>>>> origin/Jaime_Novoa


            echo "</div>";
        }

        $stmt->close();
        ?>
        <button type="submit">Enviar respuestas</button>
    </form>

    <?php
    if (!empty($resultado_mensaje)) {
        echo $resultado_mensaje;
    }
    ?>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> origin/Jaime_Novoa
