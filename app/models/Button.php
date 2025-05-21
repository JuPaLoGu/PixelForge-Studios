<?php
namespace Model;

class Button {
    private string $label;

    public function __construct(string $label) {
        $this->label = $label;
    }

    public function render(): string {
        return '<button>' . htmlspecialchars($this->label) . '</button>';
    }
}