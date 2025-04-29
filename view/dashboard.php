<?php
session_start();
require_once '../model/Empleado.php';
require_once '../model/RecursosHumanos.php';

// Validar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Recuperar el objeto usuario
$usuario = unserialize($_SESSION['usuario']);
$rol = $_SESSION['rol'] ?? '';

echo "<h1>Bienvenido, {$usuario->nombre}</h1>";

if ($rol == 'rrhh') {
    echo "<p>Eres Recursos Humanos.</p>";
} elseif ($rol == 'empleado') {
    echo "<p>Eres un Empleado.</p>";
} else {
    echo "<p>Rol desconocido.</p>";
}
?>
<a href="../public/logout.php">Cerrar sesión</a>
