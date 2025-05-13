<?php
// Primero incluimos las clases necesarias con rutas absolutas
require_once __DIR__ . '/../models/User.php';
require_once '../../config/database.php';

// Establecemos el tipo de contenido para la respuesta JSON
header('Content-Type: application/json');

// Verificamos que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos los datos enviados en formato JSON
    $data = json_decode(file_get_contents("php://input"));
    
    // Verificamos que los datos necesarios estén presentes
    if (!$data || !isset($data->username) || !isset($data->password)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Datos incompletos o formato incorrecto.'
        ]);
        exit();
    }

    // Limpiamos los datos de entrada
    $username = trim($data->username);
    $password = trim($data->password);

    // Creamos una instancia del modelo Usuario
    $userModel = new User();

    // Intentamos autenticar al usuario
    $user = $userModel->authenticate($username, $password);

    if ($user) {
        // Autenticación exitosa, iniciamos sesión
        session_start();
        
        // Guardamos los datos del usuario en la sesión
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        
        echo json_encode([
            'success' => true, 
            'message' => 'Inicio de sesión exitoso.'
        ]);
    } else {
        // Autenticación fallida
        echo json_encode([
            'success' => false, 
            'message' => 'Usuario o contraseña incorrectos.'
        ]);
    }
} else {
    // Si no es una solicitud POST, devolvemos un error
    echo json_encode([
        'success' => false, 
        'message' => 'Método no permitido.'
    ]);
}
?>