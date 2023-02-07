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
        private int|null $creado = null,
        private int|null $autor = null,
        private array $listaAutoresMegusta = [],
        private array $listaComentarios = []
    ) {
        $this->errores = [
            'texto' => $texto === null || empty($texto) ? 'El texto no puede estar vacío' : null,
            'imagen' => null
        ];
    }
    public static function crearEntradaDesdePost(array $post): Entrada
    {
        $texto = $post && isset($post['texto']) ? htmlspecialchars(trim($post['texto'])) : "";
        $autor = $post && isset($post['autor']) ? htmlspecialchars(trim($post['autor'])) : "";
        return new Entrada(
            texto: $texto,
            autor: $autor
        );
    }
    public function anyadirImagenDesdeFile(array $file): void
    {
        if (
            $file && isset($file['imagen']) &&
            $file['imagen']['error'] === UPLOAD_ERR_OK

        ) {
            $permitidos = array("png", "jpg");
            $extension =  pathinfo($file['imagen']['name'], PATHINFO_EXTENSION);
            $mimesPermitidos = array("image/jpg", "image/png", "image/jpeg");
            $fichero = $file['imagen']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_fichero = finfo_file($finfo, $fichero);
            if (in_array($extension, $permitidos) && in_array($mime_fichero, $mimesPermitidos)) {
                $tiempoactualirrepetible = getdate();
                $file['imagen']['name'] = $tiempoactualirrepetible['0'] . "." . $extension;
                $rutaFicheroDestino = './img/' . basename($file['imagen']['name']);
                move_uploaded_file($file['imagen']['tmp_name'], $rutaFicheroDestino);
                $this->imagen = $rutaFicheroDestino;
            } else {
                $this->errores['imagen'] = 'Extensión o Mime no permitido';
            }
        }
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
    public function getAutor(): int|null
    {
        return $this->autor;
    }

    public function setAutor(int $autor): void
    {
        $this->autor = $autor;
    }

    public function getTexto(): string
    {
        return $this->texto ? $this->texto : '';
    }

    public function getImagen(): string
    {
        return $this->imagen ? $this->imagen : "https://imgs.search.brave.com/Uhe3CR6P16arr9sShRWOASq_P0hGpy544ngLMcG8W9M/rs:fit:474:225:1/g:ce/aHR0cHM6Ly90c2Ux/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC5U/WUNIYmZsWkRrQVlZ/eU55TW9GNFdBSGFI/YSZwaWQ9QXBp";
    }

    public function esValida(): bool
    {
        return empty($this->errores['texto']) && empty($this->errores['imagen']);
        /*         return count($this->errores) == 0;
 */
    }
    public function getListaAutoresMeGusta(): array
    {
        return $this->listaAutoresMegusta;
    }
    public function getComentarios(): array
    {
        return $this->listaComentarios;
    }
    public function numAutores()
    {

        return count($this->listaAutoresMegusta);
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}
