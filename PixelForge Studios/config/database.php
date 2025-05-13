<?php
/**
 * Clase de configuración y conexión a la base de datos
 * Implementa el patrón Singleton para mantener una única conexión
 */
class Database {
    private static $instance = null;
    private $pdo;
    
    // Configuración de la base de datos
    private $host = 'localhost';
    private $dbname = 'pixelforgestudios1';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8';
    private $port = '3306';
    
    /**
     * Constructor privado - configura la conexión a la BD
     */
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset};port={$this->port}";
        
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $e) {
            // Registrar error en archivo de log
            error_log("Error de conexión a la BD: " . $e->getMessage());
            
            // Mostrar mensaje de error amigable
            die("Error de conexión a la base de datos. Por favor, contacte al administrador.");
        }
    }
    
    /**
     * Obtiene la única instancia de la clase
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Obtiene la conexión PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }
    
    /**
     * Método estático para acceder rápidamente a la conexión
     * @return PDO
     */
    public static function getDbConnection() {
        return self::getInstance()->getConnection();
    }
}
?>