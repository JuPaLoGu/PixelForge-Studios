<?php
namespace controllers;

use models\RecursosHumanos;

class ControladorRecursosHumanos {
    public function procesar(array $datos): void {
        $rrhh = new RecursosHumanos();
        echo nl2br(htmlspecialchars($rrhh->procesarContrato($datos)));
    }
}