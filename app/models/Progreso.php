<?php
namespace Model;
require_once 'Conexion.php';

class Progreso {
    private int $empleadoID;
    private \mysqli $db;

    public function __construct(int $empleadoID) {
        $this->empleadoID = $empleadoID;
        $this->db = (new Conexion())->getConnection();
    }

    public function obtenerPorcentaje(): float {
        $stmt = $this->db->prepare('SELECT porcentaje FROM progreso WHERE empleado_id = ? ORDER BY progreso_id DESC LIMIT 1');
        $stmt->bind_param('i', $this->empleadoID);
        $stmt->execute();
        $stmt->bind_result($porcentaje);
        $stmt->fetch();
        $stmt->close();
        return $porcentaje ?? 0.0;
    }
}
?>