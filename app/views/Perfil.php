<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edición de Perfiles</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="topbar">
        <div class="logo">
            <a href="InicioEmpleado.php">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png"
                alt="LogoPixelForge">
            </a>
        </div>

        <!-- Menú hamburguesa para pantallas pequeñas -->
        <div class="menu-toggle" id="menuToggle">
            <i class="fa fa-bars" id="menuIcon"></i>
        </div>

        <div class="topbar-center">
            <nav class="nav-links">
                <a href="Programas_Bienestar.php">Bienestar</a>
                <a href="../../ModuloCursos/Cursos_VirtualesAdmin.php">Cursos</a>
                <a href="Metas_Empleados.php">Metas</a>
                <a href="Nomina.php">Nómina</a>
                <a href="Perfil.php">Editar Perfiles</a>
            </nav>
        </div>

        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <div class="menu-desplegable" id="menu">
                    <a href="/public/logout.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú móvil -->
    <nav class="mobile-menu" id="mobileNav">
        <a href="Nomina.php">Nómina</a>
        <a href="#">Progreso</a>
        <a href="Metas_Empleados.php">Metas de empleados</a>
        <a href="#">Contratación</a>
        <a href="#">Beneficios por metas</a>
    </nav>

    <main class="inicio-container">
        <div class="texto-container">
            <h1>Lorem ipsum.</h1>
            <form method="POST" action="">

                <h2>Editar Usuario</h2>

                <label for="user_id">ID:</label>
                <input type="text" id="id" name="id"><br>

                <label for="rol">Rol:</label>
                <select name="rol" id="rol" required>
                    <option value="null">-</option>
                    <option value="empleado">Empleado</option>
                    <option value="usuario">Usuario</option>
                </select><br>

                <label for="estado">Estado:</label>
                <select name="estado" id="estado" required>
                    <option value="null">-</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select><br>

                <button type="submit">Actualizar</button>
            </form>

            <?php
            require_once '../controllers/PerfilController.php';
            $perfilController = new PerfilController();
            $perfilController->mostrarUsuarios();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $perfilController->actualizarUsuario();
            }
            exit;
            ?>

        </div>
    </main>

    <!-- Script de funcionalidad responsiva -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuario = document.getElementById("usuario");
            const menu = document.getElementById("menu");
            const toggleBtn = document.querySelector(".menu-toggle");
            const menuIcon = toggleBtn.querySelector("i");
            const mobileNav = document.getElementById("mobileNav");

            const isTouchDevice = () => window.matchMedia("(pointer: coarse)").matches;

            function closeMobileMenu() {
                if (mobileNav.classList.contains("active") && !mobileNav.classList.contains("closing")) {
                    mobileNav.classList.add("closing");

                    mobileNav.addEventListener("animationend", function handler() {
                        mobileNav.classList.remove("closing");
                        mobileNav.classList.remove("active");
                        mobileNav.removeEventListener("animationend", handler);
                    });

                    menuIcon.classList.remove("fa-times");
                    menuIcon.classList.add("fa-bars");
                    toggleBtn.classList.remove("active");
                    toggleBtn.style.color = "";
                    document.body.classList.remove("menu-open");
                }
            }

            usuario.addEventListener("click", function(e) {
                e.stopPropagation();
                const isOpen = usuario.classList.toggle("show-menu");
                usuario.classList.toggle("active");
                usuario.style.color = isOpen ? "#f73d66" : "";
            });

            document.addEventListener("click", function(e) {
                const clickEnUsuario = usuario.contains(e.target);
                const clickEnMenuHamburguesa = toggleBtn.contains(e.target) || mobileNav.contains(e.target);

                setTimeout(() => {
                    if (!clickEnMenuHamburguesa) closeMobileMenu();
                    if (!clickEnUsuario) {
                        usuario.classList.remove("show-menu", "active");
                        usuario.style.color = "";
                    }
                }, 0);
            });

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
        });
    </script>

</body>

</html>