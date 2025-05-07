<?php
class NominaBono {
    public static function asignarBono(PDO $pdo, $nomina_id, $empleado_id, $monto) {
        $stmt = $pdo->prepare("INSERT INTO nomina_bonos (nomina_id, empleado_id, monto_bono) VALUES (?, ?, ?)");
        $stmt->execute([$nomina_id, $empleado_id, $monto]);
    }
}
