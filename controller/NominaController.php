<?php
session_start();

require_once '../config/database.php';
require_once '../model/Nomina.php';
require_once '../model/NominaBono.php';
require_once '../model/ReporteNomina.php';

// Verificar si el usuario tiene el rol de RRHH
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'rrhh') {
    header('Location: ../view/acceso_denegado.php');
    exit;
}

// Validar entrada
if (empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin'])) {
    die("Fechas incompletas.");
}

$inicio = $_POST['fecha_inicio'];
$fin = $_POST['fecha_fin'];

try {
    // Iniciar transacción
    $pdo->beginTransaction();

    // 1. Crear la nómina
    $nomina_id = Nomina::crear($pdo, $inicio, $fin);

    // 2. Obtener empleados
    $stmt = $pdo->query("SELECT id FROM usuarios WHERE rol = 'empleado'");
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Asignar bonificaciones (ejemplo: monto aleatorio entre 100-300)
    foreach ($empleados as $emp) {
        $monto_bono = rand(100, 300); // Puedes cambiar esta lógica
        NominaBono::asignarBono($pdo, $nomina_id, $emp['id'], $monto_bono);
    }

    // 4. Generar reporte
    ReporteNomina::generar($pdo, "Bonificaciones generadas automáticamente.", $nomina_id);

    // Confirmar
    $pdo->commit();
    header('Location: ../view/nomina_exito.php');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al procesar la nómina: " . $e->getMessage());
}
