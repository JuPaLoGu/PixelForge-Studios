<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap"
    rel="stylesheet">
  <title>Iniciar Sesión</title>
</head>

<body>
  <form action="login.php" method="POST">
    <!-- Header -->
    <div class="header">
      <div class="header-content">
        <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
        <h2>INICIO DE SESIÓN</h2>
      </div>
    </div>

    <!-- Mensaje de error -->
    <?php if (!empty($_GET['error'])): ?>
      <div class="error-message">
        <?= htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="form-content">
      <div class="input-container">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="username" placeholder="Usuario o correo" required>
      </div>

      <div class="input-container">
        <i class="fa-solid fa-lock"></i>
        <input
          type="password"
          name="password"
          id="password-login"
          placeholder="Contraseña"
          required>
        <!-- Icono para alternar visibilidad -->
        <i
          id="toggle-password-login"
          class="fa-solid fa-eye toggle-password"
          style="cursor: pointer; margin-left: -30px;"></i>
      </div>


      <button type="submit">Iniciar sesión</button>
      <br><br>
      <a href="CambiarContraseña.php">¿Desea cambiar u olvidó su contraseña?</a>
    </div>
  </form>

  <script>
    // Alterna visibilidad de la contraseña en login
    document
      .getElementById('toggle-password-login')
      .addEventListener('click', function() {
        const pwd = document.getElementById('password-login');
        // Cambia el tipo
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        // Cambia el icono
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
  </script>

</body>

</html>