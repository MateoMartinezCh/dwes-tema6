<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Modelo;

class Home extends Controlador
{
    public function home(): void
    {
        $this->vista = 'home/home';
    }

    public function listar(): array
    {
        return [];
    }

    public function ver(): Modelo|null
    {
        return null;
    }

    public function crear(): Modelo|null
    {
        return null;
    }

    public function actualizar(): Modelo|null|array
    {
        return null;
    }

    public function eliminar(): bool
    {
        return false;
    }
}
