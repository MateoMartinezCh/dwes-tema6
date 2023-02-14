<?php

namespace dwesgram\controlador;

use dwesgram\modelo\Comentario;
use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\ComentarioBd;
use dwesgram\utility\Sesion;

class ComentarioControlador extends Controlador
{
    /**
     * 
     */
    public function nuevo(): Entrada|array|null
    {
        if (!$this->autenticado() || !$_POST) {
            header('Location:index.php');
            return null;
        }
        $comentario = Comentario::crearComentarioDesdePost($_POST);
        if ($comentario->esValido()) {
            $comentario->setId(ComentarioBd::insertar($comentario));
        }
        $this->vista = 'entrada/detalle';
        return EntradaBd::getEntrada($comentario->getEntrada());
    }
}
