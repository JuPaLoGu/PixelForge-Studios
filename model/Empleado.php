<?php
namespace Model;

class Empleado {
    private int $id;
    private string $nombre;
    private string $departamento;
    private string $fechaIngreso;

    public function __construct(int $id, string $nombre, string $departamento, string $fechaIngreso) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->departamento = $departamento;
        $this->fechaIngreso = $fechaIngreso;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDepartamento(): string {
        return $this->departamento;
    }
}
