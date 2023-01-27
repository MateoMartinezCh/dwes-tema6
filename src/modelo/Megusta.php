<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Megusta extends Modelo
{
    private array $errores = [];

    public function __construct(
        private int|null $id = null,
        private int|null $usuario = null,
        private int|null $entrada = null,
    ) {
        $this->errores = [];
    }
    public static function crearMegustaDesdeGet(array $get): Megusta
    {
        $usuario = $get && isset($get['usuario']) ? htmlspecialchars(trim($get['usuario'])) : "";
        $entrada = $get && isset($get['entrada']) ? htmlspecialchars(trim($get['entrada'])) : "";
        return new Megusta(
            usuario: $usuario,
            entrada: $entrada
        );
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getUsuario(): int|null
    {
        return $this->usuario;
    }

    public function setUsuario(int $usuario): void
    {
        $this->usuario = $usuario;
    }
    public function getEntrada(): int|null
    {
        return $this->entrada;
    }

    public function setEntrada(int $entrada): void
    {
        $this->entrada = $entrada;
    }


    public function esValido(): bool
    {
        return empty($this->errores['usuario']) && empty($this->errores['entrada']);
        //         return count($this->errores) == 0;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}
