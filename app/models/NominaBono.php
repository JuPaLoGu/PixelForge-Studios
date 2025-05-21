<?php
class NominaBono
{

    public $id;
    public $nominaId;
    public $empleadoId;
    public $montoBono;

    public function __construct($id, $nominaId, $empleadoId, $montoBono)
    {
        $this->id = $id;
        $this->nominaId = $nominaId;
        $this->empleadoId = $empleadoId;
        $this->montoBono = $montoBono;
    }

    public function agregarBono($pdo)
    {
        $sql = "INSERT INTO nomina_bonos (nomina_id, empleado_id, monto_bono) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param("ids", $this->nominaId, $this->empleadoId, $this->montoBono);
        $stmt->execute();

        return $pdo->insert_id;
    }

    public static function asignarBono(PDO $pdo, $nomina_id, $empleado_id, $monto)
    {
        $stmt = $pdo->prepare("INSERT INTO nomina_bonos (nomina_id, empleado_id, monto_bono) VALUES (?, ?, ?)");
        $stmt->execute([$nomina_id, $empleado_id, $monto]);
    }
}
