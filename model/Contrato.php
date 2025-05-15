<?php
namespace Model;

class Contrato {
    private string $tipo;
    private string $contenido;
    private \DateTime $fechaFirma;
    private string $firmaDigital;
    private Empleado $empleado;

    public function __construct(string $tipo, string $contenido, Empleado $empleado) {
        $this->tipo = $tipo;
        $this->contenido = $contenido;
        $this->empleado = $empleado;
        $this->firmaDigital = '';
    }

    public function firmar(string $firma): void {
        $this->firmaDigital = $firma;
        $this->fechaFirma = new \DateTime();
    }

    public function generarTexto(): string {
        $fecha = $this->fechaFirma->format('Y-m-d');
        return "Tipo: {$this->tipo}\n" .
               "Empleado: {$this->empleado->getNombre()} (Depto: {$this->empleado->getDepartamento()})\n" .
               "Fecha Firma: {$fecha}\nContenido:\n{$this->contenido}\nFirma Digital: {$this->firmaDigital}\n";
    }
}
