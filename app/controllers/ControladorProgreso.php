<?php
namespace Controller;

require_once '../models/Button.php';
require_once '../models/Progreso.php';
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
        //include '../views/Progreso.php';
    }
}