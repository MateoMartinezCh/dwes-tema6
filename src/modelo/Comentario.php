<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Comentario extends Modelo
{
    private array $errores = [];

    public function __construct(
        private String|null $texto,
        private int|null $id = null,
        private int|null $usuario = null,
        private int|null $entrada = null,
    ) {
        $this->errores = [];
    }
    public static function crearComentarioDesdePost(array $post): Comentario
    {
        $comentario = new Comentario(
            texto: $post && isset($post['texto']) ? htmlspecialchars(trim($post['texto'])) : "",
            usuario: $post && isset($post['usuario']) ? htmlspecialchars(trim($post['usuario'])) : "",
            entrada: $post && isset($post['entrada']) ? htmlspecialchars(trim($post['entrada'])) : ""
        );
        if (mb_strlen($comentario->texto) === 0) {
            $comentario->errores['texto'] = 'El texto del comentario no puede estar vacío';
        }
        return $comentario;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setTexto(String $texto)
    {
        $this->texto = $texto;
    }
    public function getTexto()
    {
        return $this->texto;
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
        return empty($this->errores['texto']);
        //         return count($this->errores) == 0;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}
