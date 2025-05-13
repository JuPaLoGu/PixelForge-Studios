<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap" rel="stylesheet">
  <title>Iniciar Sesión / Registrarse</title>
  <style>
    .register-toggle { margin-top: 20px; text-align: center; cursor: pointer; color: #00f; }
    .form-container { max-width: 450px; margin: auto; }
    .hidden { display: none; }
    .error-message, .success-message { text-align: center; margin-bottom: 10px; font-weight: bold; }
    .success-message { color: green; }
    .error-message { color: red; }
  </style>
</head>
<body>

<div class="form-container">
  <!-- FORMULARIO DE LOGIN -->
  <form id="loginForm">
    <div class="header">
      <div class="header-content">
        <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
        <h2>INICIO DE SESIÓN</h2>
      </div>
    </div>

    <div class="error-message" id="login-error"></div>

    <div class="form-content">
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
      <a href="CambiarContraseña.php">¿Olvidaste tu contraseña?</a>
    </div>
  </form>

  <!-- TOGGLE REGISTRO -->
  <div class="register-toggle" onclick="toggleRegister()">¿No tienes cuenta? Regístrate aquí</div>

  <!-- FORMULARIO DE REGISTRO -->
  <form id="registerForm" class="hidden">
    <h2>Registro de Usuario</h2>
    <div class="success-message" id="register-success"></div>
    <div class="error-message" id="register-error"></div>

    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="reg_username" placeholder="Nombre de usuario" required>
    </div>
    <div class="input-container">
      <i class="fa-solid fa-envelope"></i>
      <input type="email" name="reg_email" placeholder="Correo electrónico" required>
    </div>
    <div class="input-container">
      <i class="fa-solid fa-lock"></i>
      <input type="password" name="reg_password" placeholder="Contraseña" required>
    </div>
    <button type="submit">Registrarse</button>
  </form>
</div>

<script>
  // Alternar visibilidad de contraseña en login
  document.getElementById('toggle-password-login').addEventListener('click', function () {
    const pwd = document.getElementById('password-login');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });

  // Alternar entre login y registro
  function toggleRegister() {
    document.getElementById('loginForm').classList.toggle('hidden');
    document.getElementById('registerForm').classList.toggle('hidden');
  }

  // Envío del formulario de login
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

      if (result.success) {
        window.location.href = 'principal.php'; // Redirige al usuario a la página principal
      } else {
        errorBox.textContent = result.message || 'Usuario o contraseña incorrectos.';
      }
    } catch (error) {
      errorBox.textContent = 'Error de conexión con el servidor.';
    }
  });

  // Envío del formulario de registro
  document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const errorBox = document.getElementById('register-error');
    const successBox = document.getElementById('register-success');
    errorBox.textContent = '';
    successBox.textContent = '';

    const data = {
      reg_username: formData.get('reg_username'),
      reg_email: formData.get('reg_email'),
      reg_password: formData.get('reg_password')
    };

    try {
      const response = await fetch('register.php', {
      
        
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (result.success) {
        successBox.textContent = result.message || 'Usuario registrado con éxito.';
        e.target.reset(); // Limpiar campos del formulario
      } else {
        errorBox.textContent = result.message || 'Error al registrar.';
      }
    } catch (error) {
      errorBox.textContent = 'Error de conexión con el servidor.';
    }
  });
</script>

</body>
</html>