<?php
session_start();
//Verificar si el usuario es RRHH
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'rrhh') {
    header('Location: acceso_denegado.php');
    exit;
}

$mensaje_exito = $_GET['exito'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear Nómina</title>
</head>
<body>
    <h2>Crear Nueva Nómina</h2>

    <?php if ($mensaje_exito): ?>
        <p style="color: green;"><?php echo htmlspecialchars($mensaje_exito); ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="../controller/NominaController.php">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required><br><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required><br><br>

        <button type="submit">Generar Nómina</button>
    </form>
</body>
</html>