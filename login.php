<?php
session_start();
require 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos y limpiamos los datos del formulario
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Preparamos la consulta para buscar por usuario o correo
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ? OR mail = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    // Si encontramos exactamente un usuario
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        // Comparamos la contraseña (sin hash, tal cual está en tu BD)
        if ($password === $db_password) {
            // Login exitoso
            $_SESSION['username'] = $username;
            header('Location: principal.php');
            exit();
        }
    }

    // Si llegamos aquí, el usuario no existe o la contraseña es incorrecta
    $error = urlencode('Usuario o contraseña incorrectos. Intente de nuevo.');
    header("Location: index.php?error={$error}");
    exit();
}