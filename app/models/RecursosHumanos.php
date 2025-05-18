<?php
namespace models;

use PDO;
use PDOException;

class RecursosHumanos {

    private $conn; // Cambiamos $pdo por $conn

    public function __construct(PDO $conn) // Inyectamos la conexión
    {
        $this->conn = $conn;
    }
    /*public function procesarContrato(array $datos): string {
        $required = ['id','nombre','departamento','fechaIngreso','tipo','contenido','firma'];
        foreach ($required as $field) {
            if (empty($datos[$field])) {
                throw new \InvalidArgumentException("Falta el campo {$field}");
            }
        }
        $emp = new Empleado(
            (int)$datos['id'],
            $datos['nombre'],
            $datos['departamento'],
            $datos['fechaIngreso']
        );
        $contrato = new Contrato(
            $datos['tipo'],
            $datos['contenido'],
            $emp
        );
        $contrato->firmar($datos['firma']);
        return $contrato->generarTexto();
    }*/

    public function procesarContrato(array $datos): string
    {
        $required = ['id', 'nombre', 'departamento', 'fechaIngreso', 'tipo', 'contenido', 'firma'];
        foreach ($required as $field) {
            if (empty($datos[$field])) {
                throw new \InvalidArgumentException("Falta el campo {$field}");
            }
        }

        try {
            // Iniciar transacción
            $this->conn->beginTransaction();

            // Insertar en la tabla de empleados
            $stmtEmpleado = $this->conn->prepare("INSERT INTO empleados (empleado_id, usuario_id, puesto, departamento, fecha_ingreso) VALUES (:empleado_id, :usuario_id, :puesto, :departamento, :fechaIngreso)");
            $stmtEmpleado->execute([
                'empleado_id' => (int)$datos['id'], // Usamos el ID proporcionado para empleado_id
                'usuario_id' => (int)$datos['id'], // Asignamos el mismo ID a usuario_id (esto puede variar)
                'puesto' => $datos['puesto'], // Asegúrate de que estés recibiendo el puesto en $datos
                'departamento' => $datos['departamento'],
                'fechaIngreso' => $datos['fechaIngreso']
            ]);

             //Obtener el id del empleado insertado
            $empleado_id = (int)$datos['id'];

            // Insertar en la tabla de contratos
            $stmtContrato = $this->conn->prepare("INSERT INTO contratos (tipo, contenido, fecha_firma, firma_digital, empleado_id) VALUES (:tipo, :contenido, NOW(), :firmaDigital, :empleado_id)");
            $stmtContrato->execute([
                'tipo' => $datos['tipo'],
                'contenido' => $datos['contenido'],
                'firmaDigital' => $datos['firma'],
                'empleado_id' => $empleado_id,
            ]);

            // Commit de la transacción
            $this->conn->commit();

            return "Contrato guardado exitosamente.";
        } catch (PDOException $e) {
            // Rollback en caso de error
            $this->conn->rollBack();
            return "Error al guardar el contrato: " . $e->getMessage();
        }
    }
}