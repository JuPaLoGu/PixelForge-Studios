<?php
session_start();
require 'bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $password === $db_password) {
        $_SESSION['username'] = $username;
        header("Location: /ISPixelF/principal.php");
        exit();
    } else {
        header("Location: index.php?error=Usuario o contraseña incorrectos");
        exit();
    }
}
?>
