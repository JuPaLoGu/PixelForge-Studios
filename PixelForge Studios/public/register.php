<?php
// Activar la visualización de errores en pantalla
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ruta base
// define('BASE_PATH', dirname(__DIR__));

// Incluir conexión y controlador
require_once '../config/Database.php';
require_once '../app/controllers/RegisterController.php';

// Obtener datos JSON enviados por fetch
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos.']);
    exit;
}

// Conexión a la base de datos utilizando el método correcto
$conexion = Database::getDbConnection();  // Usar getDbConnection() en lugar de conectar()

// Crear instancia del controlador con conexión
$controller = new RegisterController($conexion);

// Llamar al método registrarUsuario() en el controlador
$response = $controller->registrarUsuario($input);

// Devolver la respuesta en formato JSON
echo json_encode($response);
exit;
