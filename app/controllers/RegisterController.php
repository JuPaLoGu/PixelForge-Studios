<?php
class RegisterController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function registrarUsuario(array $input) {
        $username = trim($input['reg_username'] ?? '');
        $email = trim($input['reg_email'] ?? '');
        $password = $input['reg_password'] ?? '';

        // Verificar si los datos están vacíos
        if (empty($username) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios.'];
        }

        // Log para verificar si los datos están llegando correctamente
        error_log("Datos recibidos - Username: $username, Email: $email");

        // Verificar si el usuario o el correo ya están registrados
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);

        $count = $stmt->fetchColumn();
        error_log("Usuarios encontrados: $count"); // Log para verificar la cantidad de registros encontrados

        if ($count > 0) {
            return ['success' => false, 'message' => 'El usuario o correo ya está registrado.'];
        }

        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        
        // Ejecutar la consulta
        $success = $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        // Verificar si la consulta fue exitosa
        if ($success) {
            return ['success' => true, 'message' => 'Usuario registrado con éxito.'];
        } else {
            // Log para verificar si ocurrió algún error al ejecutar la consulta
            $errorInfo = $stmt->errorInfo();
            error_log("Error al registrar el usuario: " /*. print_r($errorInfo, true)*/);
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }
 }

?>