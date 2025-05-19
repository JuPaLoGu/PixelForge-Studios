<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nomina</title>

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
            <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
        </div>

        <!-- Título del módulo o página -->
        <div class="topbar-left">
            <label>Nomina</label>
        </div>

        <!-- Navegación principal en pantallas grandes -->
        <div class="topbar-center">
            <nav class="nav-links">
                <a href="beneficio.php">Bienestar</a>
                <a href="">Talleres</a>
                <a href="">Cursos</a>
                <a href="">Tour virtual</a>
                <a href="Metas_Empleados.php">Metas</a>
                <a href="CrearNomina.php">Nómina</a>
                <a href="Perfil.php">Editar Perfiles</a>
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
        <a href="beneficio.php">Bienestar</a>
        <a href="#">Cursos</a>
        <a href="#">Tour virtual</a>
        <a href="Metas_Empleados.php">Metas</a>
        <a href="Nomina.php">Nómina</a>
        <a href="Perfil.php">Editar Perfiles</a>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="inicio-container">
        <!-- Sección del logo -->
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png" alt="LogoPixelForge" />
        </div>

        <!-- Sección del texto principal -->
        <div class="texto-container">
            <h1>Reporte de Nómina de Cursos Terminados</h1>

            <?php
            require_once '../../config/database.php';

            try {
                // Conexión a la base de datos
                $db = Database::getInstance();
                $pdo = $db->getConnection();

                // Consulta SQL para obtener los usuarios que han terminado el curso
                // La tabla 'progreso' contiene la información sobre el estado del curso.
                $sql = "SELECT u.id, u.username, c.titulo
                FROM users u
                INNER JOIN progreso p ON u.id = p.empleado_id
                INNER JOIN cursos c ON p.curso_id = c.curso_id
                WHERE p.porcentaje = 100";

                // Preparar la consulta
                $stmt = $pdo->prepare($sql);

                // Ejecutar la consulta
                $stmt->execute();

                // Obtener todos los resultados como un array asociativo
                $usuarios_terminaron_curso = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Verificar si se encontraron usuarios
                if (count($usuarios_terminaron_curso) > 0) {
            ?>
                    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">ID de Usuario</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Apellido</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nombre del Curso</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php foreach ($usuarios_terminaron_curso as $usuario) { ?>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo $usuario['id']; ?></td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo $usuario['nombre']; ?></td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo $usuario['apellido']; ?></td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo $usuario['nombre_curso']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
            <?php
                } else {
                    echo "<p class='text-center text-gray-500 py-4'>Ningun usuario a completado un curso.</p>";
                }
            } catch (PDOException $e) {
                echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>
                <strong class='font-bold'>Error:</strong>
                <span class='block sm:inline'>Ocurrió un error al consultar la base de datos: " . $e->getMessage() . "</span>
              </div>";
            }
            ?>

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