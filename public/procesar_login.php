<?php
session_start();
require_once '../config/database.php';
require_once '../model/Empleado.php';
require_once '../model/RecursosHumanos.php';

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Crear objeto del tipo correcto
    if ($user['rol'] == 'empleado') {
        $usuario = new Empleado($user);
    } elseif ($user['rol'] == 'rrhh') {
        $usuario = new RecursosHumanos($user);
    } else {
        header('Location: ../view/login.php?error=rol');
        exit;
    }

    $_SESSION['usuario'] = serialize($usuario); // Guardamos el objeto serializado
    $_SESSION['rol'] = $user['rol'];

    header('Location: ../view/dashboard.php');
    exit;
} else {
    header('Location: ../view/login.php?error=1');
    exit;
}