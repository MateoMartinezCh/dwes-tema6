<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;

class EntradaControlador extends Controlador
{

    public function lista(): array
    {
        $this->vista  = "home/home";
        return [];
    }

    public function detalle(): Entrada|null
    {
        return null;
    }

    public function nuevo(): Entrada|null
    {
        return null;
    }

    public function eliminar(): bool|null
    {
        return null;
    }
}
