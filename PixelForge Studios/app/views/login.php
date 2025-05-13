<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Asegúrate que la ruta sea correcta -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <form method="POST" action="">
        <div class="header">
            <div class="header-content">
                <img src="assets/img/logo.png" alt="Logo"> <!-- Cambia la ruta si es necesario -->
                <h2>Pixel Forge Studios</h2>
            </div>
        </div>
        <div class="form-content">
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" name="clave" placeholder="Contraseña" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
</body>
</html>
