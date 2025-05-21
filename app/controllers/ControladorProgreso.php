<?php

namespace Controller;

require_once '../models/Button.php';
require_once '../models/Progreso.php';

use Model\Button;
use Model\Progreso;

class ControladorProgreso
{

    public function mostrar(): void
    {

        /*$botones = [
            new Button('Inicio'),
            new Button('Módulo 1'),
            new Button('Módulo 2'),
            new Button('Finalizado')
        ];
        $progreso = new Progreso(1);
        $porcentaje = $progreso->obtenerPorcentaje();
        //include '../views/Progreso.php';
    }
        */

        // Iniciar la sesión. ¡Haz esto UNA SOLA VEZ al principio de tu aplicación!
        // No es ideal en el controlador, pero si no lo tienes globalmente, aquí es donde lo necesitarías.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // ==============================================================
        //  Obtener el ID del empleado actual de la sesión.
        //  ¡IMPORTANTE!: Reemplaza 'empleado_id' por la clave real de tu sesión.
        // ==============================================================
        $empleadoId = $_SESSION['empleado_id'] ?? null; // Usa empleado_id o como lo tengas en tu sesión

        if ($empleadoId === null) {
            // Manejar el caso donde el empleado no está logueado.
            echo "<p>Necesitas iniciar sesión para ver tu progreso.</p>";
            // O redirigir: header('Location: /login.php'); exit();
            return;
        }

        // ==============================================================
        //  Instanciar el modelo Progreso con el ID del empleado
        //  y obtener la lista de cursos con su progreso individual.
        // ==============================================================
        $progresoModel = new Progreso($empleadoId);
        $cursosDelEmpleado = $progresoModel->obtenerProgresoDeCursosDelEmpleado(); // Llama al nuevo método

        // Tus botones estáticos (si aún los quieres en la vista).
        $botones = [
            new Button('Inicio'),
            new Button('Módulo 1'),
            new Button('Módulo 2'),
            new Button('Finalizado')
        ];

        // ==============================================================
        //  Incluir la vista HTML (Progreso.php).
        //  Las variables $cursosDelEmpleado y $botones estarán disponibles en la vista.
        // ==============================================================
        // Descomenta y verifica la ruta.
        // Si tu HTML está en la raíz junto a la carpeta controllers, '../Progreso.php' es correcto.
        // Si tu HTML está en una carpeta 'views' (ej. 'views/Progreso.php'), sería '../views/Progreso.php'.
        include '../Progreso.php';
    }
}
