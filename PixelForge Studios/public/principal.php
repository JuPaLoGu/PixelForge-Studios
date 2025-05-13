<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Bienvenida, <?php echo htmlspecialchars($_SESSION['user']); ?> 🎮</h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
