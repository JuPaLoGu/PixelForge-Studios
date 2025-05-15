<?php
namespace Model;

class RecursosHumanos {
    public function procesarContrato(array $datos): string {
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
    }
}
