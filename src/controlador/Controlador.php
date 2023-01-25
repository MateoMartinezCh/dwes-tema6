<?php

namespace dwesgram\controlador;

use dwesgram\utility\Sesion;

abstract class Controlador
{
    protected string $vista;

    public function getVista(): string
    {
        return $this->vista;
    }
    public function autenticado(): bool
    {
        $sesion = new Sesion();
        if (!$sesion->haySesion()) {
            $this->vista = 'errores/403';
            return false;
        }
        return true;
    }
}
