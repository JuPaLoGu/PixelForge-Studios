<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Cursos virtuales</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="Cursos_Virtuales.css">
</head>

<body>
    <div class="topbar">
        <div class="logo">
            <a href="../app/views/InicioCliente.php">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png"
                    alt="LogoPixelForge">
            </a>
        </div>
        <div class="topbar-left">
            <label for="">Cursos <br> virtuales</label>
        </div>
        <div class="topbar-center">
            <nav>
                <a href="../app/views/Programas_BienestarCliente.php">Bienestar</a>
<<<<<<< HEAD
=======
                <a href="../app/views/ProgresoCliente.php">Progreso</a>
>>>>>>> origin/Jaime_Novoa
                <a href="">Cursos</a>
                <a href="../app/views/ContratacionCliente.php">Contratación</a>
            </nav>
        </div>
        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <span>Empleado</span>
                <div class="menu-desplegable" id="menu">
                    <a href="#">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

    <main class="inicio-container">
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png"
                alt="LogoPixelForge">
        </div>
        <div class="botones-cursos" id="contenedor-botones">
            <button id="btn-cursos">Cursos <br> virtuales</button>
            <button id="btn-registro">Registro <br> cursos virtuales</button>
            <button id="btn-avance">Ver avance <br> cursos virtuales</button>
        </div>

        <div class="contenido-secciones oculto" id="contenedor-secciones">
            <div id="seccion-cursos" class="seccion oculto">
                <h1>Cursos virtuales</h1>
                <?php
                session_start();
                $conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
                $conexion->set_charset("utf8");

                if ($conexion->connect_error) {
                    echo "<p style='color: red;'>Error de conexión: " . htmlspecialchars($conexion->connect_error) . "</p>";
                } else {
                    function obtenerImagenCurso($id)
                    {
                        $imagenes = [
                            1 => 'imagenes/animacion3D.png',
                            2 => 'imagenes/niveles.png',
                            3 => 'imagenes/unreal.svg',
                        ];
                        return isset($imagenes[$id]) ? $imagenes[$id] : 'imagenes/default.png';
                    }

                    $sql = "SELECT curso_id, titulo, duracion, descripcion, cupos_disponibles FROM cursos";
                    $resultado = $conexion->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        echo '<div class="cursos-container">';
                        while ($curso = $resultado->fetch_assoc()) {
                            $curso_id = isset($curso['curso_id']) ? $curso['curso_id'] : 0;
                            echo '<div class="curso-box">';
                            echo '<img src="' . htmlspecialchars(obtenerImagenCurso($curso_id)) . '" alt="Curso ' . htmlspecialchars($curso['titulo']) . '">';
                            echo '<h2>' . htmlspecialchars($curso['titulo']) . '</h2>';
                            echo '<p><strong>Duración:</strong> ' . htmlspecialchars($curso['duracion']) . ' horas</p>';
                            echo '<p>' . htmlspecialchars($curso['descripcion']) . '</p>';
                            echo '<p><strong>Cupos disponibles:</strong> ' . htmlspecialchars($curso['cupos_disponibles']) . '</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p>No hay cursos disponibles en este momento.</p>';
                    }
                    $conexion->close();
                }
                ?>
            </div>

            <div id="seccion-registro" class="seccion oculto">
                <h1>Registro de cursos virtuales</h1>
                <?php
                $conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
                $conexion->set_charset("utf8");

                if ($conexion->connect_error) {
                    echo "<p style='color: red;'>Error de conexión: " . htmlspecialchars($conexion->connect_error) . "</p>";
                } else {
                    $sql = "SELECT curso_id, titulo, duracion, descripcion, cupos_disponibles FROM cursos";
                    $resultado = $conexion->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        echo '<div class="cursos-registro-container">';
                        while ($curso = $resultado->fetch_assoc()) {
                            $curso_id = isset($curso['curso_id']) ? $curso['curso_id'] : 0;
                            echo '<div class="curso-registro-box">';
                            echo '<img src="' . htmlspecialchars(obtenerImagenCurso($curso_id)) . '" alt="Curso ' . htmlspecialchars($curso['titulo']) . '" style="width: 200px; height: auto;">';
                            echo '<h2>' . htmlspecialchars($curso['titulo']) . '</h2>';
                            echo '<a href="formulario_inscripcion.php?curso_id=' . htmlspecialchars($curso_id) . '" class="btn-registrarse">Registrarse</a>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p>No hay cursos disponibles para registro.</p>';
                    }
                    $conexion->close();
                }
                ?>
            </div>

            <div id="seccion-avance" class="seccion oculto">
                <h1>Avance</h1>
                <?php
                $conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
                $conexion->set_charset("utf8");

                if ($conexion->connect_error) {
                    echo "<p style='color: red;'>Error de conexión: " . htmlspecialchars($conexion->connect_error) . "</p>";
                } else {
                    if (isset($_SESSION['mensaje_resultado'])) {
                        $msg = $_SESSION['mensaje_resultado'];
                        echo "<div style='border:2px solid " . ($msg['aprobado'] ? "green" : "red") . "; padding: 10px; margin-bottom: 20px;'>";
                        echo "<h3>Resultado del Quiz</h3>";
                        echo "<p>Preguntas correctas: " . htmlspecialchars($msg['aciertos']) . " de " . htmlspecialchars($msg['total']) . "</p>";
                        echo "<p>Porcentaje: " . htmlspecialchars($msg['porcentaje']) . "%</p>";
                        echo $msg['aprobado'] ? "<p style='color:green;'>¡Felicidades! Has aprobado el módulo.</p>" : "<p style='color:red;'>No aprobaste el módulo, inténtalo nuevamente.</p>";
                        echo "</div>";
                        unset($_SESSION['mensaje_resultado']);
                    }

                    $sql = "SELECT curso_id, titulo, duracion, descripcion, cupos_disponibles FROM cursos";
                    $resultado = $conexion->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        echo '<div class="cursos-container">';
                        while ($curso = $resultado->fetch_assoc()) {
                            $curso_id = isset($curso['curso_id']) ? $curso['curso_id'] : 0;
                            echo '<div class="curso-box">';
                            echo '<img src="' . htmlspecialchars(obtenerImagenCurso($curso_id)) . '" alt="Curso ' . htmlspecialchars($curso['titulo']) . '">';
                            echo '<h2>' . htmlspecialchars($curso['titulo']) . '</h2>';
                            echo '<p><strong>Duración:</strong> ' . htmlspecialchars($curso['duracion']) . ' horas</p>';
                            echo '<p>' . htmlspecialchars($curso['descripcion']) . '</p>';
                            echo '<a href="validar_acceso.php?curso_id=' . htmlspecialchars($curso_id) . '" class="btn-validar">Ingresar correo para avanzar</a>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p>No hay cursos disponibles en este momento.</p>';
                    }
                    $conexion->close();
                }
                ?>
            </div>

            <button id="btn-volver" class="boton-volver oculto">Volver</button>
        </div>
    </main>

    <footer>
        <img src="https://pixelforgestudio.com/wp-content/themes/pixelforgestudioventure/assets/public/images/pixel-div-bot.png"
            style="width: 100%; display: block;" alt="Imagen del footer">
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuario = document.getElementById('usuario');
            const menu = document.getElementById('menu');

            usuario.addEventListener('click', function(e) {
                e.stopPropagation();
                usuario.classList.toggle('show-menu');
            });

            document.addEventListener('click', function(e) {
                if (!usuario.contains(e.target)) {
                    usuario.classList.remove('show-menu');
                }
            });

            function mostrarSeccion(id) {
                document.getElementById("contenedor-botones").classList.add("oculto");
                document.getElementById("contenedor-secciones").classList.remove("oculto");
                document.querySelector(".logo-container").classList.add("oculto");
                document.querySelectorAll(".seccion").forEach(sec => sec.classList.add("oculto"));
                document.getElementById(id).classList.remove("oculto");
                document.getElementById("btn-volver").classList.remove("oculto");
            }

            document.getElementById("btn-cursos").addEventListener("click", () => mostrarSeccion("seccion-cursos"));
            document.getElementById("btn-registro").addEventListener("click", () => mostrarSeccion("seccion-registro"));
            document.getElementById("btn-avance").addEventListener("click", () => mostrarSeccion("seccion-avance"));

            document.getElementById("btn-volver").addEventListener("click", () => {
                document.getElementById("contenedor-secciones").classList.add("oculto");
                document.getElementById("contenedor-botones").classList.remove("oculto");
                document.querySelector(".logo-container").classList.remove("oculto");
                document.querySelectorAll(".seccion").forEach(sec => sec.classList.add("oculto"));
                document.getElementById("btn-volver").classList.add("oculto");
            });
        });
    </script>
</body>

</html>