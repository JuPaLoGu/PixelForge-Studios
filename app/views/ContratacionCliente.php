<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contratación</title>

    <!-- Iconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- Fuente IBM Plex Sans Condensed desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap" rel="stylesheet" />

    <!-- Fuente Open Sans desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <!-- TOPBAR: Encabezado superior con logo, título y navegación -->
    <div class="topbar">
        <!-- Logo con enlace -->
        <div class="logo">
            <a href="InicioCliente.php">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
            </a>
        </div>

        <!-- Título del módulo o página -->
        <div class="topbar-left">
            <label>Contratación</label>
        </div>

        <!-- Navegación principal en pantallas grandes -->
        <div class="topbar-center">
            <nav class="nav-links">
                <a href="Programas_BienestarCliente.php">Bienestar</a>
<<<<<<< HEAD
=======
                <a href="ProgresoCliente.php">Progreso</a>
>>>>>>> origin/Jaime_Novoa
                <a href="../../ModuloCursos/Cursos_Virtuales.php">Cursos</a>
                <a href="">Contratación</a>
            </nav>
        </div>

        <!-- Botón de menú móvil y menú desplegable del usuario (RRHH) -->
        <div class="topbar-right">
            <!-- Botón hamburguesa para menú móvil -->
            <div class="menu-toggle" id="menuToggle">
                <i class="fa fa-bars" id="menuIcon"></i>
            </div>

            <!-- Usuario con ícono y nombre + menú desplegable -->
            <div class="topbar-right">
                <div class="input-container" id="usuario">
                    <i class="fa-solid fa-user"></i>
                    <div class="menu-desplegable" id="menu">
                        <a href="/public/logout.php">Cerrar sesión</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MENÚ MÓVIL: Se muestra en dispositivos pequeños -->
    <nav class="mobile-menu" id="mobileNav">
        <a href="Programas_BienestarCliente.php">Bienestar</a>
        <a href="ProgresoCliente.php">Progreso</a>
        <a href="../../ModuloCursos/Cursos_Virtuales.php">Cursos</a>
        <a href="ContratacionCliente.php">Contratación</a>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="inicio-container">
        <!-- Sección del logo -->
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png" alt="LogoPixelForge" />
        </div>

        <!-- Sección del texto principal -->
        <div class="texto-container">

            <div class="container">
                <h1>Formulario de Contrato</h1>
                <form method="POST" action="">
                    <br><input type="hidden" name="action" value="procesar">
                    <label for="id">ID:</label></br>
                    <input type="number" id="id" name="id" required>
                    <br><label for="nombre">Nombre:</label></br>
                    <input type="text" id="nombre" name="nombre" required>
                    <br><label for="departamento">Departamento:</label></br>
                    <input type="text" id="departamento" name="departamento" required>
                    <br><label for="fechaIngreso">Fecha de Ingreso:</label></br>
                    <input type="date" id="fechaIngreso" name="fechaIngreso" required>
                    <br><label for="tipo">Tipo de Contrato:</label></br>
                    <input type="text" id="tipo" name="tipo" required>
                    <br><label for="contenido">Contenido:</label></br>
                    <textarea id="contenido" name="contenido" required></textarea>
                    <br><label for="firma">Firma:</label></br>
                    <input type="text" id="firma" name="firma" required>
                    <button type="submit">Enviar</button>
                </form>

                <?php

                require_once '../controllers/ControladorRecursosHumanos.php';
                require_once '../models/RecursosHumanos.php';
                require_once '../models/Empleado.php';
                require_once '../models/Contrato.php';
                require_once '../../config/database.php';

                use controllers\ControladorRecursosHumanos;
                use models\RecursosHumanos;
                use database; // Usamos la clase Database
                // Obtener la conexión a la base de datos usando el patrón Singleton
                $db = Database::getInstance();
                $conn = $db->getConnection();

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'procesar') {
                    $rh = new RecursosHumanos($conn); // Pasamos la conexión al constructor
                    $resultado = $rh->procesarContrato($_POST);
                    echo $resultado;
                }
                ?>
            </div>
        </div>
    </main>

    <!-- PIE DE PÁGINA -->
    <footer>
        <img src="https://pixelforgestudio.com/wp-content/themes/pixelforgestudioventure/assets/public/images/pixel-div-bot.png" style="width: 100%; display: block;" alt="Imagen del footer" />
    </footer>

    <!-- SCRIPT PARA INTERACTIVIDAD -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuario = document.getElementById("usuario");
            const menu = document.getElementById("menu");
            const toggleBtn = document.querySelector(".menu-toggle");
            const menuIcon = toggleBtn.querySelector("i");
            const mobileNav = document.getElementById("mobileNav");

            // Verifica si es un dispositivo táctil
            const isTouchDevice = () => window.matchMedia("(pointer: coarse)").matches;

            // Función para cerrar el menú móvil con animación
            function closeMobileMenu() {
                if (mobileNav.classList.contains("active") && !mobileNav.classList.contains("closing")) {
                    mobileNav.classList.add("closing");

                    mobileNav.addEventListener("animationend", function handler() {
                        mobileNav.classList.remove("closing");
                        mobileNav.classList.remove("active");
                        mobileNav.removeEventListener("animationend", handler);
                    });

                    // Restaurar icono y color al cerrar
                    menuIcon.classList.remove("fa-times");
                    menuIcon.classList.add("fa-bars");
                    toggleBtn.classList.remove("active");
                    toggleBtn.style.color = ""; // Color por defecto
                    document.body.classList.remove("menu-open");
                }
            }

            // Alternar visibilidad del menú de usuario (RRHH)
            usuario.addEventListener("click", function(e) {
                e.stopPropagation();
                const isOpen = usuario.classList.toggle("show-menu");
                usuario.classList.toggle("active");

                // Cambiar color según estado
                if (isOpen) {
                    usuario.style.color = "#f73d66";
                } else {
                    usuario.style.color = "";
                }
            });

            // Cerrar menús si se hace clic fuera
            document.addEventListener("click", function(e) {
                const clickEnUsuario = usuario.contains(e.target);
                const clickEnMenuHamburguesa = toggleBtn.contains(e.target) || mobileNav.contains(e.target);

                // Timeout evita conflictos visuales
                setTimeout(() => {
                    if (!clickEnMenuHamburguesa) {
                        closeMobileMenu();
                    }

                    if (!clickEnUsuario) {
                        usuario.classList.remove("show-menu", "active");
                        usuario.style.color = "";
                    }
                }, 0);
            });

            // Mostrar u ocultar el menú móvil (hamburguesa)
            toggleBtn.addEventListener("click", function(e) {
                e.stopPropagation();

                if (document.body.classList.contains("menu-open")) {
                    toggleBtn.style.color = "";
                    closeMobileMenu();
                } else {
                    toggleBtn.classList.add("active");
                    menuIcon.classList.remove("fa-bars");
                    menuIcon.classList.add("fa-times");
                    document.body.classList.add("menu-open");
                    mobileNav.classList.add("active");
                    toggleBtn.style.color = "#f73d66";
                }
            });

            // Función para cambiar el color de botón según estado
            const updateButtonColor = (button, isOpen) => {
                if (button, isOpen) {
                    button.style.color = "#ffffff"; // Color por defecto
                } else {
                    button.style.color = "#f73d66"; // Color activo
                }
            };

            // Aplicar cambios al botón hamburguesa
            toggleBtn.addEventListener("click", function() {
                const isOpen = toggleBtn.classList.contains("active");
                updateButtonColor(toggleBtn, !isOpen);
            });

            // Aplicar cambios al botón del usuario
            usuario.addEventListener("click", function() {
                const isOpen = usuario.classList.contains("active");
                updateButtonColor(usuario, !isOpen);
            });
        });
    </script>

</body>

</html>