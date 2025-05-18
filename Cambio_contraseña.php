<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Cambio_contraseña.css">
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
    </div>
    <!-- Formulario de registro -->
    <form method="post" action="login.php" class="hidden">
        <!-- Div del header -->
        <div class="header">
            <div class="header-content">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
                <h2>CAMBIO DE CONTRASEÑA</h2>
            </div>
        </div>

        <br>
        <!-- Div del Formulario -->
        <div class="form-content">
            <!-- Div del nombre -->
            <div class="input-container">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="Nombre" placeholder="Nombre de usuario" required>
            </div>

            <!-- Div de la nueva contraseña -->
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="new-password" id="new-password" placeholder="Nueva contraseña" required>
                <span id="toggle-new-password" class="fa-solid fa-eye toggle-password" style="cursor: pointer; margin-left: -30px;"></span>
            </div>

            <button type="submit">Cambiar contraseña</button>
            <br><br>
            <a href="Inicio_sesion.php" class="cancelar">Cancelar</a>
        </div>
    </form>

    <!-- SCRIPT PARA INTERACTIVIDAD -->

    <script>
        // Alterna visibilidad de la nueva contraseña

        document
            .getElementById('toggle-new-password')
            .addEventListener('click', function() {
                const pwd = document.getElementById('new-password');
                // Cambia el tipo
                pwd.type = pwd.type === 'password' ? 'text' : 'password';
                // Cambia el icono
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
    </script>

</body>


</html>