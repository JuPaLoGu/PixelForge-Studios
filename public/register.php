<?php
// register.php

// Mostrar errores para debugging (quitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluye tu conexión a base de datos
require_once '../config/Database.php';

// Función simple para validar mail
function validar_mail($mail) {
    return filter_var($mail, FILTER_VALIDATE_EMAIL);
}

// Lee JSON enviado
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos.']);
    exit;
}

// Variables recibidas
$username = trim($input['reg_username'] ?? '');
$mail = trim($input['reg_mail'] ?? '');
$password = $input['reg_password'] ?? '';

// Validaciones básicas
if (empty($username) || empty($mail) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

if (!validar_mail($mail)) {
    echo json_encode(['success' => false, 'message' => 'El correo electrónico no es válido.']);
    exit;
}

try {
    // Conectar a la base de datos
    $db = Database::getDbConnection();

    // Verificar si el usuario o correo ya existen
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR mail = :mail");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':mail', $mail);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario o correo ya están registrados.']);
        exit;
    }

    // Hashear la contraseña
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $db->prepare("INSERT INTO users (username, mail, password) VALUES (:username, :mail, :password)");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':password', $hashPassword);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Registro exitoso. Ahora puedes iniciar sesión.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
