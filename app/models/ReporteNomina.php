<?php
class ReporteNomina {
    public static function generar(PDO $pdo, $detalle, $nomina_id) {
        $fecha = date('Y-m-d');
        $stmt = $pdo->prepare("INSERT INTO reporte_nomina (detalle, fecha_generacion, nomina_id) VALUES (?, ?, ?)");
        $stmt->execute([$detalle, $fecha, $nomina_id]);
    }
}
