<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="logout.php">Cerrar sesión</a>
    <?php if (isset($_SESSION['user_id'])): ?>
  <div style="text-align: center; margin-top: 30px;">
    <a href="editar_perfil.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">
      Editar Perfil
    </a>
  </div>
<?php endif; ?>
</body>
</html>
