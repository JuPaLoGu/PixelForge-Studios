<?php

namespace Model;

require_once 'Conexion.php';

class Progreso
{
    private int $empleadoID;
    private \mysqli $db;

    public function __construct(int $empleadoID)
    {
        $this->empleadoID = $empleadoID;
        $this->db = (new Conexion())->getConnection();
    }

    /**
     * Obtiene el progreso de cada curso en el que el empleado está inscrito (según la tabla 'registro'),
     * calculando el porcentaje basado en las lecciones que ha completado (si hay datos disponibles)
     * y el estado de aprobación del examen de ese curso.
     *
     * @return array Un array de arrays, cada uno representando un curso con su progreso y estado del examen.
     */
    public function obtenerProgresoDeCursosDelEmpleado(): array
    {
        $cursos = [];
        $query = "
            SELECT
                c.curso_id AS curso_id,
                c.titulo AS titulo_curso,
                COUNT(DISTINCT l.id) AS lecciones_totales,
                -- ADVERTENCIA: Sin una tabla de 'empleados_lecciones_completadas' o similar,
                -- no podemos contar lecciones completadas. Esto será 0 por defecto.
                -- Si tienes otra forma de identificar lecciones completadas, ajusta esta línea.
                0 AS lecciones_completadas,
                MAX(CASE WHEN e.aprobado = 1 THEN 1 ELSE 0 END) AS examen_aprobado,
                MAX(e.puntaje) AS examen_puntaje_max
            FROM
                registro r                           -- Usamos tu tabla 'registro' para las inscripciones
            INNER JOIN
                cursos c ON r.id_curso = c.curso_id  -- Une con la tabla cursos
            LEFT JOIN
                lecciones l ON c.curso_id = l.id_modulo -- Une con lecciones (usando id_modulo de lecciones)
            LEFT JOIN
                examenes e ON r.id_empleado = e.empleado_id AND r.id_curso = e.id_curso AND e.aprobado = 1
            WHERE
                r.id_empleado = ?
            GROUP BY
                c.curso_id, c.titulo
            ORDER BY
                c.titulo;
        ";

        $stmt = $this->db->prepare($query);
        // 'i' para empleadoID. Si empleado_id es BIGINT y puede exceder PHP_INT_MAX, cambia a 's'.
        $stmt->bind_param('i', $this->empleadoID);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $totalLecciones = $row['lecciones_totales'] ?? 0;
            $leccionesCompletadas = $row['lecciones_completadas'] ?? 0; // Será 0 si no se puede trackear

            $porcentajeProgreso = 0.0;
            // Si el examen está aprobado, el curso se considera 100% completado.
            if ($row['examen_aprobado']) {
                $porcentajeProgreso = 100.0;
            } else {
                // Si no hay examen aprobado y no tenemos lecciones completadas, el progreso es 0.
                // Si tuvieras una forma de contar lecciones completadas, iría aquí:
                // if ($totalLecciones > 0) { $porcentajeProgreso = ($leccionesCompletadas / $totalLecciones) * 100; }
            }

            $cursos[] = [
                'curso_id' => $row['curso_id'],
                'titulo' => $row['titulo_curso'],
                'lecciones_totales' => $totalLecciones,
                'lecciones_completadas' => $leccionesCompletadas,
                'porcentaje_progreso' => $porcentajeProgreso,
                'examen_aprobado' => (bool)$row['examen_aprobado'],
                'examen_puntaje_max' => $row['examen_puntaje_max']
            ];
        }
        $stmt->close();
        return $cursos;
    }
}
