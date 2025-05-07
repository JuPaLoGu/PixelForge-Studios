<?php
class Nomina {
    public $id;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->fecha_inicio = $data['fecha_inicio'];
        $this->fecha_fin = $data['fecha_fin'];
    }

    public static function crear(PDO $pdo, $inicio, $fin) {
        $stmt = $pdo->prepare("INSERT INTO nomina (fecha_inicio, fecha_fin) VALUES (?, ?)");
        $stmt->execute([$inicio, $fin]);
        return $pdo->lastInsertId();
    }
}
