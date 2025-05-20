<?php
$conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$mensaje = "";
$mensaje_clase = "mensaje";

// Capturamos curso_id tanto si viene por POST como por GET
$curso_id = $_POST["curso_id"] ?? $_GET["curso_id"] ?? null;

if (!$curso_id) {
    die("Error: No se especificó un curso.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);

    if (empty($nombre) || empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo incorrecto.";
        $mensaje_clase = "error";
    } else {
        // Validar si el empleado existe
        $stmt = $conexion->prepare("SELECT id FROM users WHERE mail = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            $mensaje = "Aún no estás registrado, regístrate para acceder a nuestros cursos.";
            $mensaje_clase = "error";
        } else {
            $empleado = $resultado->fetch_assoc();
            $id_empleado = $empleado["id"];

            // Validar si ya está inscrito en el curso
            $stmt = $conexion->prepare("SELECT id FROM registro WHERE id_empleado = ? AND id_curso = ?");
            $stmt->bind_param("ii", $id_empleado, $curso_id);
            $stmt->execute();
            $res_inscrito = $stmt->get_result();

            if ($res_inscrito->num_rows > 0) {
                $mensaje = "Ya estás inscrito en este curso.";
                $mensaje_clase = "error";
            } else {
                // Verificar cupos disponibles
                $stmt = $conexion->prepare("SELECT cupos_disponibles FROM cursos WHERE curso_id = ?");
                $stmt->bind_param("i", $curso_id);
                $stmt->execute();
                $resultado_curso = $stmt->get_result();

                if ($resultado_curso->num_rows > 0) {
                    $curso = $resultado_curso->fetch_assoc();
                    if ($curso["cupos_disponibles"] > 0) {
                        // Insertar inscripción
                        $stmt = $conexion->prepare("INSERT INTO registro (id_curso, id_empleado, fecha_inscripcion) VALUES (?, ?, NOW())");
                        $stmt->bind_param("ii", $curso_id, $id_empleado);
                        if ($stmt->execute()) {
                            $conexion->query("UPDATE cursos SET cupos_disponibles = cupos_disponibles - 1 WHERE curso_id = $curso_id");
                            $mensaje = "¡Inscripción exitosa! Serás redirigido en unos segundos...";
                            $mensaje_clase = "exito";

                            // Redirigir con JavaScript
                            echo "<script>
                                setTimeout(function() {
                                    window.location.href = 'Cursos_Virtuales.php';
                                }, 3000);
                            </script>";
                        } else {
                            $mensaje = "Error al registrar la inscripción.";
                            $mensaje_clase = "error";
                        }
                    } else {
                        $mensaje = "Lo sentimos, en este momento no tenemos cupos disponibles.";
                        $mensaje_clase = "error";
                    }
                } else {
                    $mensaje = "Curso no encontrado.";
                    $mensaje_clase = "error";
                }
            }
        }
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Inscripción</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff;
      margin: 0;
      padding: 0;
    }

    .form-container {
      max-width: 800px;
      margin: 40px auto;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .form-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .form-group {
      flex: 0 0 48%;
    }

    label {
      display: flex;
      align-items: center;
      font-weight: bold;
      color: #c44158;
      margin-bottom: 8px;
      font-size: 14px;
      text-transform: uppercase;
    }

    label i {
      margin-right: 8px;
    }

    input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }

    .submit-btn {
      display: inline-block;
      background-color: #ff007f;
      color: white;
      border: none;
      padding: 14px 30px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .submit-btn:hover {
      background-color: #e60073;
    }

    .message {
      margin-top: 20px;
      font-size: 16px;
      padding: 10px;
      border-radius: 4px;
      text-align: center;
    }

    .exito {
      background-color: #ff007f;
      color: white;
    }

    .error {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <form action="formulario_inscripcion.php" method="POST">
      <!-- Campo oculto con el curso_id -->
      <input type="hidden" name="curso_id" value="<?= htmlspecialchars($curso_id) ?>">

      <div class="form-row">
        <div class="form-group">
          <label for="nombre"><i class="fa fa-user"></i> First Name</label>
          <input type="text" id="nombre" name="nombre" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group" style="flex: 1;">
          <label for="correo"><i class="fa fa-at"></i> Email Address</label>
          <input type="email" id="correo" name="correo" required>
        </div>
      </div>

      <button type="submit" class="submit-btn">Inscribirse</button>
    </form>

    <?php if (!empty($mensaje)): ?>
      <div class="message <?= $mensaje_clase ?>"><?= $mensaje ?></div>
    <?php endif; ?>
  </div>

</body>
</html>
