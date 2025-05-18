<?php
namespace Controller;

use Model\Button;
use Model\Progreso;

class ControladorProgreso {
    public function mostrar(): void {
        $botones = [
            new Button('Inicio'),
            new Button('Módulo 1'),
            new Button('Módulo 2'),
            new Button('Finalizado')
        ];
        $progreso = new Progreso(1);
        $porcentaje = $progreso->obtenerPorcentaje();
        include __DIR__ . '/../view/progreso.php';
    }
}