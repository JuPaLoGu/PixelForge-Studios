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
            <a href="../app/views/InicioEmpleado.php">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png"
                alt="LogoPixelForge">
            </a>
        </div>
        <div class="topbar-left">
            <label for="">Cursos <br> virtuales</label>
        </div>
        <div class="topbar-center">
            <nav>
                <a href="../app/views/Programas_Bienestar.php">Bienestar</a>
                <a href="../../ModuloCursos/Cursos_VirtualesAdmin.php">Cursos</a>
                <a href="../app/views/Metas_Empleados.php">Metas</a>
                <a href="../app/views/Nomina.php">Nómina</a>
                <a href="../app/views/Perfil.php">Editar Perfiles</a>
            </nav>

        </div>
        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <span>Empleado</span>
                <div class="menu-desplegable" id="menu">
                    <a href="../public/logout.php">Cerrar sesión</a>
                </div>
            </div>

        </div>
    </div>

    <main class="inicio-container">
        <?php
        session_start();
        $conexion = new mysqli("localhost", "root", "", "pixelforgestudios");
        $conexion->set_charset("utf8");

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        // Procesar actualización de cupos si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["curso_id"]) && isset($_POST["cupos_disponibles"])) {
            $curso_id = intval($_POST["curso_id"]);
            $cupos = intval($_POST["cupos_disponibles"]);

            $stmt = $conexion->prepare("UPDATE cursos SET cupos_disponibles = ? WHERE curso_id = ?");
            $stmt->bind_param("ii", $cupos, $curso_id);

            if ($stmt->execute()) {
                $mensaje = "Cupos actualizados correctamente.";
            } else {
                $mensaje = "Error al actualizar los cupos.";
            }

            $stmt->close();
        }

        function obtenerImagenCurso($curso_id)
        {
            $imagenes = [
                1 => 'imagenes/animacion3D.png',
                2 => 'imagenes/niveles.png',
                3 => 'imagenes/unreal.svg',
            ];
            return $imagenes[$curso_id] ?? 'imagenes/default.png';
        }

        $sql = "SELECT * FROM cursos";
        $resultado = $conexion->query($sql);
        ?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <title>Cursos Virtuales (Admin)</title>
            <link rel="stylesheet" href="estilos.css">
        </head>

        <body>
            <header>
                <h1>Gestión de Cursos Virtuales</h1>
                <p>Bienvenido, Administrador</p>
            </header>

            <?php if (isset($mensaje)): ?>
                <div style="background-color: #e0ffe0; padding: 10px; border: 1px solid #00aa00; margin: 10px;">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <div id="seccion-cursos">
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    echo '<div class="cursos-container">';
                    while ($curso = $resultado->fetch_assoc()) {
                        echo '<div class="curso-box">';
                        echo '<img src="' . obtenerImagenCurso($curso['curso_id']) . '" alt="Curso">';
                        echo '<h2>' . htmlspecialchars($curso['titulo']) . '</h2>';
                        echo '<p><strong>Duración:</strong> ' . $curso['duracion'] . ' horas</p>';
                        echo '<p>' . htmlspecialchars($curso['descripcion']) . '</p>';

                        // Formulario para editar cupos
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="curso_id" value="' . $curso['curso_id'] . '">';
                        echo '<label for="cupos">Cupos disponibles:</label>';
                        echo '<input type="number" name="cupos_disponibles" value="' . $curso['cupos_disponibles'] . '" min="0">';
                        echo '<button type="submit">Actualizar</button>';
                        echo '</form>';

                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>No hay cursos disponibles en este momento.</p>';
                }

                $conexion->close();
                ?>
            </div>




    </main>

    <!-- Menú desplegable del perfil del usuario -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuario = document.getElementById('usuario');
            const menu = document.getElementById('menu');

            // Maneja el clic sobre el icono o el texto "RRHH"
            usuario.addEventListener('click', function(e) {
                e.stopPropagation(); // Evita que el clic fuera del contenedor lo oculte
                usuario.classList.toggle('show-menu'); // Alterna el estado del menú
            });

            // Cierra el menú si se hace clic fuera del contenedor
            document.addEventListener('click', function(e) {
                if (!usuario.contains(e.target)) {
                    usuario.classList.remove('show-menu'); // Oculta el menú si se hace clic fuera
                }
            });
        });
    </script>








    <!-- Sección desplegable de cada botón de los cursos virtuales -->




    <script>
        // Función para mostrar una sección y ocultar los botones
        function mostrarSeccion(id) {
            // Oculta el contenedor de botones
            document.getElementById("contenedor-botones").classList.add("oculto");

            // Muestra el contenedor de secciones
            document.getElementById("contenedor-secciones").classList.remove("oculto");

            // Oculta todas las secciones previamente visibles
            document.querySelectorAll(".seccion").forEach(sec => sec.classList.add("oculto"));

            // Muestra la sección específica seleccionada
            document.getElementById(id).classList.remove("oculto");


            // Muestra el botón de volver
            document.getElementById("btn-volver").classList.remove("oculto");
        }

        // Asignar eventos a los botones principales
        document.getElementById("btn-cursos").addEventListener("click", () => {
            mostrarSeccion("seccion-cursos");
        });

        document.getElementById("btn-registro").addEventListener("click", () => {
            mostrarSeccion("seccion-registro");
        });

        document.getElementById("btn-avance").addEventListener("click", () => {
            mostrarSeccion("seccion-avance");
        });

        // Evento para el botón de volver
        document.getElementById("btn-volver").addEventListener("click", () => {
            // Oculta el contenedor de secciones
            document.getElementById("contenedor-secciones").classList.add("oculto");

            // Muestra el contenedor con los tres botones
            document.getElementById("contenedor-botones").classList.remove("oculto");

            // Oculta todas las secciones
            document.querySelectorAll(".seccion").forEach(sec => sec.classList.add("oculto"));

            // Oculta el botón de volver
            document.getElementById("btn-volver").classList.add("oculto");
        });
    </script>





    <script>
        const botones = document.querySelectorAll('.botones-cursos button');
        const secciones = document.querySelectorAll('.contenido-secciones .seccion');

        botones.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-target');

                // Oculta todas las secciones
                secciones.forEach(sec => sec.classList.add('oculto'));

                // Muestra solo la sección correspondiente
                const mostrar = document.getElementById(target);
                if (mostrar) {
                    mostrar.classList.remove('oculto');
                    window.scrollTo({
                        top: mostrar.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>




    <footer>
        <img src="https://pixelforgestudio.com/wp-content/themes/pixelforgestudioventure/assets/public/images/pixel-div-bot.png"
            style="width: 100%; display: block;" alt="Imagen del footer">
    </footer>
</body>

</html>