<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Registro de usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap" rel="stylesheet">
</head>

<body>

    <form action="PaginaPrincipal.php">
        <!-- Div del header -->
        <div class="header">
            <div class="header-content">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
                <h2>REGISTRO DE USUARIO</h2>
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
            <div class="input-container">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="Correo" placeholder="Correo de usuario">
            </div>

            <!-- Div de la contraseña -->
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input id="password-register" type="password" name="Contraseña" placeholder="Contraseña de usuario">
                <span id="toggle-password-register" class="fa-solid fa-eye" style="cursor: pointer;"></span>
            </div>

            <!-- Div de la confirmación de contraseña -->
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input id="confirm-password-register" type="password" name="Confirmar_contraseña" placeholder="Confirme su contraseña">
                <span id="toggle-confirm-password-register" class="fa-solid fa-eye" style="cursor: pointer;"></span>
            </div>

            <button type="submit">Registrarse</button>
            <br><br>
            <a href="Inicio_sesion.php">Iniciar sesión</a>
        </div>
    </form>

    <script>
        // Función para alternar la visibilidad de la contraseña en el registro
        document.getElementById('toggle-password-register').addEventListener('click', function() {
            const passwordField = document.getElementById('password-register');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // Cambiar el ícono de "fa-eye" a "fa-eye-slash" y viceversa
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Función para alternar la visibilidad de la confirmación de la contraseña en el registro
        document.getElementById('toggle-confirm-password-register').addEventListener('click', function() {
            const passwordField = document.getElementById('confirm-password-register');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // Cambiar el ícono de "fa-eye" a "fa-eye-slash" y viceversa
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>


</html>