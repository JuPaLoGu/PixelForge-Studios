<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap" rel="stylesheet">
  <title>Iniciar Sesión</title>
  <style>
    .form-container {
      max-width: 450px;
      margin: auto;
    }

    .error-message {
      text-align: center;
      color: red;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="form-container">
    <form id="loginForm">
      <div class="header">
        <div class="header-content">
          <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
          <h2>INICIO DE SESIÓN</h2>
        </div>
      </div>

      <div class="form-content">
        <div class="error-message" id="login-error"></div>
        <div class="input-container">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="username" id="username" placeholder="Usuario o correo" required>
        </div>

        <div class="input-container">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" id="password-login" placeholder="Contraseña" required>
          <i id="toggle-password-login" class="fa-solid fa-eye toggle-password" style="cursor: pointer; margin-left: -30px;"></i>
        </div>

        <button type="submit">Iniciar sesión</button><br><br>
        <a href="CambiarContraseña.php">¿Olvidaste tu contraseña?</a><br>
        <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('toggle-password-login').addEventListener('click', function() {
      const pwd = document.getElementById('password-login');
      pwd.type = pwd.type === 'password' ? 'text' : 'password';
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    document.getElementById('loginForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const errorBox = document.getElementById('login-error');
      errorBox.textContent = '';

      const data = {
        username: formData.get('username'),
        password: formData.get('password')
      };

      try {
        const response = await fetch('../app/controllers/LoginController.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        /*if (result.success) {
          window.location.href = '../app/views/Inicio.php';
        } else {
          errorBox.textContent = result.message || 'Usuario o contraseña incorrectos.';
        }*/

        if (result.success) {
          // Redirigir según el rol
          switch (result.rol) {
            case 'empleado':
              window.location.href = '../app/views/InicioEmpleado.php'; // Reemplaza con tu página de empleado
              break;
            case 'usuario':
              window.location.href = '../app/views/InicioCliente.php'; // Reemplaza con tu página de cliente
              break;
          }
        } else {
          errorBox.textContent = result.message || 'Usuario o contraseña incorrectos.';
        }

      } catch (error) {
        errorBox.textContent = 'Error de conexión con el servidor.';
      }
    });
  </script>
</body>

</html>