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

    public function generarNomina($pdo) {        
        $sql = "INSERT INTO nomina (fecha_inicio, fecha_fin) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param("ss", $this->fecha_inicio, $this->fecha_fin);
        $stmt->execute();

        $nominaId = $pdo->insert_id;
        $this->id = $nominaId;

        return $nominaId;
    }

     public function generarReporteNomina($pdo, $tipoReporte, $filtros = []) {
        // Lógica para generar el reporte de nómina con tipo de reporte
        // $tipoReporte: 'nomina', 'bonos', 'deducciones' (según el caso de uso)
        // $filtros: array con criterios de filtrado

        $sql = "";
        switch ($tipoReporte) {
            case 'nomina':
                $sql = "SELECT n.*, e.nombre, e.departamento, e.puesto 
                        FROM nomina n
                        INNER JOIN empleado e ON n.id = e.empleado_id  -- Suponiendo que hay una relación directa
                        WHERE 1=1";
                break;
            case 'bonos':
                $sql = "SELECT nb.*, n.*, e.nombre, e.departamento
                        FROM nomina_bonos nb
                        INNER JOIN nomina n ON nb.nomina_id = n.id
                        INNER JOIN empleado e ON nb.empleado_id = e.empleado_id
                        WHERE 1=1";
                break;
            default:
                return ["error" => "Tipo de reporte no válido"];
        }

        // Agregar filtros
        if (isset($filtros['fechaInicio'])) {
            $sql .= " AND n.fecha_inicio >= '" . $filtros['fechaInicio'] . "'"; // Asumiendo fecha en 'nomina'
        }
        if (isset($filtros['fechaFin'])) {
            $sql .= " AND n.fecha_fin <= '" . $filtros['fechaFin'] . "'"; // Asumiendo fecha en 'nomina'
        }
        if (isset($filtros['empleadoId'])) {
            $sql .= " AND e.empleado_id = '" . $filtros['empleadoId'] . "'"; // Asumiendo empleado_id en 'empleado'
        }
        if (isset($filtros['departamento'])) {
            $sql .= " AND e.departamento = '" . $filtros['departamento'] . "'";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $reporte = [];
        while ($fila = $result->fetch_assoc()) {
            $reporte[] = $fila;
        }

        return $reporte;
    }

       public function mostrarDetallesNomina($pdo) {
        // (Como antes, muestra detalles de una nómina específica)
        $sql = "SELECT n.*, nb.monto_bono, e.nombre 
                FROM nomina n
                LEFT JOIN nomina_bonos nb ON n.id = nb.nomina_id
                INNER JOIN empleado e ON nb.empleado_id = e.empleado_id
                WHERE n.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $detalles = [];
        while ($fila = $result->fetch_assoc()) {
            $detalles[] = $fila;
        }

        return $detalles;
    }

}
