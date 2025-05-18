<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap" rel="stylesheet" />
  <title>Registro de Usuario</title>
  <style>
    .form-container { max-width: 450px; margin: auto; }
    .error-message { text-align: center; color: red; font-weight: bold; }
    .success-message { text-align: center; color: green; font-weight: bold; }
  </style>
</head>

<body>
  <div class="form-container">
    <form id="registerForm">
      <div class="header-content">
        <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
        <h2>Registro de Usuario</h2>
      </div>

      <div class="success-message" id="register-success"></div>
      <div class="error-message" id="register-error"></div>

      <div class="input-container">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="reg_username" placeholder="Nombre de usuario" required />
      </div>

      <div class="input-container">
        <i class="fa-solid fa-envelope"></i>
        <input type="mail" name="reg_mail" placeholder="Correo electrónico" required />
      </div>

      <div class="input-container">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="reg_password" placeholder="Contraseña" required />
      </div>

      <button type="submit">Registrarse</button><br /><br />
      <a href="index.php">¿Ya tienes cuenta? Inicia sesión aquí</a>
    </form>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const formData = new FormData(e.target);
      const errorBox = document.getElementById('register-error');
      const successBox = document.getElementById('register-success');
      errorBox.textContent = '';
      successBox.textContent = '';

      const data = {
        reg_username: formData.get('reg_username'),
        reg_mail: formData.get('reg_mail'),
        reg_password: formData.get('reg_password'),
      };

      try {
        const response = await fetch('register.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.success) {
          successBox.textContent = result.message || 'Usuario registrado con éxito.';
          e.target.reset();
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
