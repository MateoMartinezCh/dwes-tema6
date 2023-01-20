<?php

namespace dwesgram\controlador;

abstract class Controlador
{
    protected string $vista;

    public function getVista(): string
    {
        return $this->vista;
    }
}
