

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Progreso</title>

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
<<<<<<< HEAD
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
=======
            <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
>>>>>>> origin/Jaime_Novoa
            </a>
        </div>

        <!-- Título del módulo o página -->
        <div class="topbar-left">
            <label>Progreso</label>
        </div>

        <!-- Navegación principal en pantallas grandes -->
        <div class="topbar-center">
            <nav class="nav-links">
                <a href="Programas_BienestarCliente.php">Bienestar</a>
                <a href="ProgresoCliente.php">Progreso</a>
                <a href="../../ModuloCursos/Cursos_Virtuales.php">Cursos</a>
                <a href="ContratacionCliente.php">Contrato</a>
            </nav>
        </div>

        <!-- Botón de menú móvil y menú desplegable del usuario (RRHH) -->
        <div class="topbar-right">
            <!-- Botón hamburguesa para menú móvil -->
            <div class="menu-toggle" id="menuToggle">
                <i class="fa fa-bars" id="menuIcon"></i>
                <a href="../../public/logout.php">Cerrar sesión</a>
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
        <a href="../app/views/ContratacionCliente.php">Contrato</a>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="inicio-container">
        <!-- Sección del logo -->
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png" alt="LogoPixelForge" />
        </div>

        <!-- Sección del texto principal -->

        <div class="texto-container">
            <h1>Mi progreso</h1>
            <!--
            <div class="buttons">
                <p
                require_once  '../controllers/ControladorProgreso.php';

                use controller\ControladorProgreso;

                (new ControladorProgreso())->mostrar();
                ?>
            </div>
        </div>
        -->
            <?php if (empty($cursosDelEmpleado)): ?>
                <p>No hay cursos registrados para usted.</p>
            <?php else: ?>
                <?php foreach ($cursosDelEmpleado as $curso): ?>
                    <div class="course-card">
                        <h3><?= htmlspecialchars($curso['titulo']) ?></h3>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: <?= $curso['porcentaje_progreso'] ?>%;">
                                <?= round($curso['porcentaje_progreso'], 0) ?>%
                            </div>
                        </div>
                        <?php if ($curso['examen_aprobado']) { ?>
                            <p class="status completed">Estado: Examen Aprobado</p>
                            <?php if ($curso['examen_puntaje_max'] !== null) { ?>
                                <p>Puntaje del Examen: <?= htmlspecialchars($curso['examen_puntaje_max']) ?></p>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="status in-progress">Estado: Examen Pendiente</p>
                            <p>Lecciones: <?= $curso['lecciones_completadas'] ?>/<?= $curso['lecciones_totales'] ?> completadas</p>
                        <?php } ?>
                        <a href="/ruta/a/tu/curso.php?curso_id=<?= htmlspecialchars($curso['curso_id']) ?>" class="btn-continue">Ver Curso</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>


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