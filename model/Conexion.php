<?php
namespace Model;

class Conexion {
    private \mysqli $conn;

    public function __construct() {
        $this->conn = new \mysqli('localhost','root','','pixelforgestudios');
        if ($this->conn->connect_error) {
            die('Conexión fallida: ' . $this->conn->connect_error);
        }
    }

    public function getConnection(): \mysqli {
        return $this->conn;
    }
}
