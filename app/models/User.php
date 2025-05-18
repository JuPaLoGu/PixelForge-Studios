<?php
class User {
    private $pdo;

    /**
     * Constructor - obtiene la conexión a la base de datos
     */
    public function __construct() {
        $this->pdo = Database::getDbConnection();
    }

    /**
     * Verifica si el nombre de usuario ya existe
     * @param string $username Nombre de usuario a verificar
     * @return bool True si el usuario existe, false en caso contrario
     */
    public function userExists($username) {
        try {
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Registra un nuevo usuario
     * @param string $username Nombre de usuario
     * @param string $email Correo electrónico
     * @param string $password Contraseña (ya debe estar hasheada)
     * @return bool True si el registro fue exitoso, false en caso contrario
     */
    public function register($username, $email, $password) {
        try {
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Autentica a un usuario con nombre de usuario/email y contraseña
     * @param string $username Nombre de usuario o email
     * @param string $password Contraseña
     * @return array|null Datos del usuario si la autenticación es exitosa, null en caso contrario
     */
    public function authenticate($username, $password) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username OR mail = :mail";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':mail', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error al autenticar usuario: " . $e->getMessage());
            return null;
        }
    }
}
?>