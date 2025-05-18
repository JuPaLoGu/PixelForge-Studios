<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap" rel="stylesheet" />

    <title>Registro de usuario</title>

<body>

    <!-- TOPBAR: Encabezado superior con logo, título y navegación -->
    <div class="topbar">
        <!-- Logo con enlace -->
        <div class="logo">
            <a href="">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
            </a>
        </div>

        <!-- Navegación principal en pantallas grandes -->
        <div class="topbar-center">
            <nav class="nav-links">
                <a href="Inicio_sesion.php">Iniciar sesión</a>
                <a href="Registro_Usuario.php">Registrarse</a>
            </nav>
        </div>

        <!-- Botón de menú móvil -->
        <div class="topbar-right">

            <!-- Botón hamburguesa para menú móvil -->
            <div class="menu-toggle" id="menuToggle">
                <i class="fa fa-bars" id="menuIcon"></i>
            </div>
        </div>
    </div>

    <!-- MENÚ MÓVIL: Se muestra en dispositivos pequeños -->
    <nav class="mobile-menu" id="mobileNav">
        <a href="Inicio_sesion.php">Iniciar sesión</a>
        <a href="Registro_Usuario.php">Registrarse</a>
    </nav>

    <!-- Formulario de registro -->
    <form method="post" action="login.php" class="hidden">
        <!-- Div del header -->
        <div class="header">
            <div class="header-content">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
                <h2>REGISTRO DE USUARIO</h2>
            </div>
        </div>

        <?php if ($registroMensaje): ?>
            <p><?= $registroMensaje ?></p>
        <?php endif; ?>

        <br>
        <!-- Div del Formulario -->
        <div class="form-content">
            <!-- Div del nombre -->
            <div class="input-container">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="Nombre" placeholder="Nombre de usuario" required>
            </div>

            <!-- Div de la contraseña -->
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password-register" placeholder="Contraseña" required>
                <!-- Icono para alternar visibilidad -->
                <span id="toggle-password-register" class="fa-solid fa-eye toggle-password" style="cursor: pointer; margin-left: -30px;"></span>
            </div>

            <!-- Div de la confirmación de contraseña -->
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="Confirmar_contraseña" id="confirm-password-register" placeholder="Confirme su contraseña" required>
                <span id="toggle-password-confirm" class="fa-solid fa-eye toggle-password" style="cursor: pointer; margin-left: -30px;"></span>
            </div>

            <button type="submit">Registrarse</button>
            <br><br>
            <a href="Inicio_sesion.php" class="inicio-sesion">Iniciar sesión</a>
        </div>
    </form>

    <!-- SCRIPT PARA INTERACTIVIDAD -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // Cerrar menús si se hace clic fuera
            document.addEventListener("click", function(e) {
                const clickEnMenuHamburguesa = toggleBtn.contains(e.target) || mobileNav.contains(e.target);

                // Timeout evita conflictos visuales
                setTimeout(() => {
                    if (!clickEnMenuHamburguesa) {
                        closeMobileMenu();
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

        });
    </script>

    <script>
        // Alterna visibilidad de la contraseña
        document
            .getElementById('toggle-password-register')
            .addEventListener('click', function() {
                const pwd = document.getElementById('password-register');
                // Cambia el tipo
                pwd.type = pwd.type === 'password' ? 'text' : 'password';
                // Cambia el icono
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

        document
            .getElementById('toggle-password-confirm')
            .addEventListener('click', function() {
                const pwd = document.getElementById('confirm-password-register');
                // Cambia el tipo
                pwd.type = pwd.type === 'password' ? 'text' : 'password';
                // Cambia el icono
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
    </script>

</body>


</html>