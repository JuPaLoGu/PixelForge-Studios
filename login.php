<?php
session_start();
require 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos y limpiamos los datos del formulario
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Preparamos la consulta para buscar por usuario o correo
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR mail = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    // Si encontramos exactamente un usuario
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $user_name, $db_password);
        $stmt->fetch();

        // Comparamos la contraseña (sin hash, como está en tu BD actual)
        if ($password === $db_password) {
            // Login exitoso: guardamos el ID en sesión
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $user_name;

            header('Location: principal.php');
            exit();
        }
    }

    // Si llegamos aquí, el usuario no existe o la contraseña es incorrecta
    $error = urlencode('Usuario o contraseña incorrectos. Intente de nuevo.');
    header("Location: index.php?error={$error}");
    exit();
}
