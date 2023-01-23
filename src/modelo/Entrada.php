<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Entrada extends Modelo
{
    private array $errores = [];

    public function __construct(
        private string|null $texto,
        private int|null $id = null,
        private string|null $imagen = null,
        private int|null $creado = null
    ) {
        $this->errores = [
            'texto' => $texto === null || empty($texto) ? 'El texto no puede estar vacío' : null,
            'imagen' => null
        ];
    }
    public static function crearEntradaDesdePost(array $post): Entrada
    {
        $texto = $post && isset($post['texto']) ? htmlspecialchars(trim($post['texto'])) : "";

        return new Entrada(
            texto: $texto
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
    public function getCreado(): int|null
    {
        return $this->creado;
    }

    public function setCreado(int $creado): void
    {
        $this->creado = $creado;
    }

    public function getTexto(): string
    {
        return $this->texto ? $this->texto : '';
    }

    public function getImagen(): string|null
    {
        return $this->imagen ? $this->imagen : "https://imgs.search.brave.com/Uhe3CR6P16arr9sShRWOASq_P0hGpy544ngLMcG8W9M/rs:fit:474:225:1/g:ce/aHR0cHM6Ly90c2Ux/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC5U/WUNIYmZsWkRrQVlZ/eU55TW9GNFdBSGFI/YSZwaWQ9QXBp";
    }

    public function esValida(): bool
    {
        return empty($this->errores['texto']);
        /*         return count($this->errores) == 0;
 */
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}
