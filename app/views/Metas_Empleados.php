<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metas de empleados</title>

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
            <a href="Principal_RRHH.php">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
            </a>
        </div>

        <!-- Título del módulo o página -->
        <div class="topbar-left">
            <label>Metas de <br>empleados</label>
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
                        <a href="Perfil.php">Perfil</a>
                        <a href="/public/logout.php">Cerrar sesión</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MENÚ MÓVIL: Se muestra en dispositivos pequeños -->
    <nav class="mobile-menu" id="mobileNav">
        <a href="Nomina.php">Nómina</a>
        <a href="Progreso.php">Progreso</a>
        <a href="Metas_Empleados.php">Metas de empleados</a>
        <a href="Contratacion.php">Contratación</a>
        <a href="Beneficios_Metas.php">Beneficios por metas</a>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="inicio-container">

        <!-- Sección del texto principal -->
        <div class="texto-container">
            <h1>Lorem ipsum.</h1>
            <p>

                <?php
                // Incluye el archivo de configuración de la base de datos
                require_once('../../config/database.php');

                try {
                    // Obtiene la conexión a la base de datos
                    $db = Database::getDbConnection();

                    // Modifica la consulta SQL para contar la cantidad de empleados por curso
                    $sql = "SELECT c.curso_id, c.titulo AS nombre_curso, COUNT(p.empleado_id) AS cantidad_empleados
                    FROM cursos c
                    LEFT JOIN progreso p ON c.curso_id = p.curso_id
                    GROUP BY c.curso_id, c.titulo"; // Agrupamos por curso_id y nombre_curso


                    // Prepara la consulta
                    $stmt = $db->prepare($sql);

                    // Ejecuta la consulta
                    $stmt->execute();

                    // Obtiene los resultados
                    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Muestra los resultados en una tabla
                    if (count($resultados) > 0) {
                        echo "<table>";
                        echo "<thead><tr><th>ID Curso</th><th>Nombre Curso</th><th>Cantidad de Empleados</th></tr></thead>";
                        echo "<tbody>";
                        foreach ($resultados as $resultado) {
                            echo "<tr>";
                            echo "<td>" . $resultado['curso_id'] . "</td>";
                            echo "<td>" . $resultado['nombre_curso'] . "</td>";
                            echo "<td>" . $resultado['cantidad_empleados'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "No se encontraron registros de cursos.";
                    }
                } catch (PDOException $e) {
                    // Maneja errores de la base de datos
                    error_log("Error al obtener la cantidad de empleados por curso: " . $e->getMessage());
                    echo "Error al obtener la cantidad de empleados por curso: " . $e->getMessage();
                }
                ?>

            </p>
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