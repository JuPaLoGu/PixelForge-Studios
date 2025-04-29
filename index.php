<?php
session_start();

// Conexión
$host = "localhost";
$dbname = "pixelforgestudios";
$user = "root";
$pass = ""; // cámbialo si usas contraseña
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$registroMensaje = "";

// Procesar registro si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrarse'])) {
    $username = $_POST['reg_username'] ?? '';
    $email = $_POST['reg_email'] ?? '';
    $password = $_POST['reg_password'] ?? '';

    if ($username && $email && $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, mail, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password_hash);

        if ($stmt->execute()) {
            $registroMensaje = "✅ Usuario registrado correctamente. Ahora puedes iniciar sesión.";
        } else {
            $registroMensaje = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $registroMensaje = "⚠️ Completa todos los campos para registrarte.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400&family=Orbitron:wght@300;400&family=Oxanium:wght@200;300;400&display=swap"
    rel="stylesheet">
  <title>Iniciar Sesión / Registrarse</title>
  <style>
    .register-toggle { margin-top: 20px; text-align: center; cursor: pointer; color: #00f; }
    .form-container { max-width: 400px; margin: auto; }
    .hidden { display: none; }
  </style>
</head>

<body>

<div class="form-container">
  <!-- Formulario de inicio de sesión -->
  <form action="login.php" method="POST" id="login-form">
    <div class="header">
      <div class="header-content">
        <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">
        <h2>INICIO DE SESIÓN</h2>
      </div>
    </div>

    <?php if (!empty($_GET['error'])): ?>
      <div class="error-message">
        <?= htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <div class="form-content">
      <div class="input-container">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="username" placeholder="Usuario o correo" required>
      </div>
      <div class="input-container">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" id="password-login" placeholder="Contraseña" required>
        <i id="toggle-password-login" class="fa-solid fa-eye toggle-password" style="cursor: pointer; margin-left: -30px;"></i>
      </div>
      <button type="submit">Iniciar sesión</button><br><br>
      <a href="CambiarContraseña.php">¿Desea cambiar u olvidó su contraseña?</a>
    </div>
  </form>

  <!-- Botón para mostrar el registro -->
  <div class="register-toggle" onclick="toggleRegister()">¿No tienes cuenta? Regístrate aquí</div>

  <!-- Formulario de registro -->
  <form method="post" action="" id="register-form" class="hidden">
    <h2>Registro de Usuario</h2>
    <?php if ($registroMensaje): ?>
      <p><?= $registroMensaje ?></p>
    <?php endif; ?>
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
    <button type="submit" name="registrarse">Registrarse</button>
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

  // Mostrar/ocultar formularios
  function toggleRegister() {
    document.getElementById('login-form').classList.toggle('hidden');
    document.getElementById('register-form').classList.toggle('hidden');
  }
</script>

</body>
</html>
