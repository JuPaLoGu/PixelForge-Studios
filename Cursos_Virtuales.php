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
            <a href="">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png"
                    alt="LogoPixelForge">
            </a>
        </div>
        <div class="topbar-left">
            <label for="">Cursos <br> virtuales</label>
        </div>
        <div class="topbar-center">
            <nav>
                <a href="Cursos_Virtuales.php" class="salto-linea">Cursos<br>virtuales</a>
                <a href="Contrato.php">Contrato</a>
                <a href="Programas_Bienestar.php" class="salto-linea">Programas de<br>bienestar</a>
            </nav>

        </div>
        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <span>Empleado</span>
                <div class="menu-desplegable" id="menu">
                    <a href="#">Perfil</a>
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
        <!-- Contenedor de los botones -->
        <div class="botones-cursos" id="contenedor-botones">
            <button id="btn-cursos">Cursos <br> virtuales</button>
            <button id="btn-registro">Registro <br> cursos virtuales</button>
            <button id="btn-avance">Ver avance <br> cursos virtuales</button>
        </div>

        <!-- Contenedor de secciones (oculto inicialmente) -->
        <div class="contenido-secciones oculto" id="contenedor-secciones">
            <div id="seccion-cursos" class="seccion oculto">
                <h1>Cursos virtuales</h1>
                <p>Aquí se muestran los cursos disponibles...</p>
            </div>

            <div id="seccion-registro" class="seccion oculto">
                <h1>Registro</h1>
                <p>Formulario de registro de cursos...</p>
            </div>

            <div id="seccion-avance" class="seccion oculto">
                <h1>Avance</h1>
                <p>Aquí se muestra el progreso de los cursos...</p>
            </div>

            <!-- Botón para volver -->
            <button id="btn-volver" class="boton-volver oculto">Volver</button>
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


    <footer>
        <img src="https://pixelforgestudio.com/wp-content/themes/pixelforgestudioventure/assets/public/images/pixel-div-bot.png"
            style="width: 100%; display: block;" alt="Imagen del footer">
    </footer>
</body>

</html>