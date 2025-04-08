<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inicio de sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap" rel="stylesheet">

</head>

<body>

    <form action="PaginaPrincipal.php">
        <!-- Div del header -->
        <div class="header">
            <div class="header-content">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
                <h2>INICIO DE SESIÓN</h2>
            </div>
        </div>

        <br>
        <!-- Div del Formulario -->
        <div class="form-content">

            <!-- Div del nombre -->
            <div class="input-container">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="Nombre" placeholder="Nombre de usuario">
            </div>

            <!-- Div del correo -->
            <!--
            <div class="input-container">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="Correo" placeholder="Correo de usuario">
            </div>
            -->

            <!-- Div de la contraseña -->
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input id="password-login" type="password" name="Contraseña" placeholder="Contraseña de usuario">
                <span id="toggle-password-login" class="fa-solid fa-eye" style="cursor: pointer;"></span>
            </div>

            <button type="submit">Iniciar sesión</button>
            <br><br>
            <a href="CambiarContraseña.php">¿Desea cambiar u olvidó su contraseña?</a>
        </div>
    </form>

    <script>
        // Función para alternar la visibilidad de la contraseña en el inicio de sesión
        document.getElementById('toggle-password-login').addEventListener('click', function() {
            const passwordField = document.getElementById('password-login');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // Cambiar el ícono de "fa-eye" a "fa-eye-slash" y viceversa
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>