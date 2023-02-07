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
     * !ESTE METODO NO ESTA TERMINADO NI FUNCIONA AÚN
     */
    public function nuevo(): Entrada|array|null
    {
        if (!$this->autenticado() || !$_GET) {
            header('Location:index.php');
            return null;
        }
        $comentario = Comentario::crearComentarioDesdePost($_POST);
        if ($comentario->esValido()) {
            //$comentario->setId(ComentarioBd::insertar($comentario));

            if (isset($_GET['vuelta']) && $_GET['vuelta'] == 'detalle') {
                $this->vista = 'entrada/detalle';
                return EntradaBd::getEntrada($comentario->getEntrada());
            }
            $this->vista = 'entrada/lista';
            return EntradaBd::getEntradas();
        }
    }
    /* public function quitar(): Entrada|array|null
    {
        if (!$this->autenticado() || !$_GET) {
            header('Location:index.php');
            return null;
        }
         
         * !POSIBLE ERROR TAL VEZ PUEDE QUITAR ME GUSTA UN NO AUTORIZADO
         * isset($_GET['usuario']) || $_GET['usuario'] !== $sesion->getId() 
        $sesion = new Sesion();
        $comentario = Comentario::crearComentarioDesdeGet($_GET);
        $entradaid = $comentario->getEntrada();
        $entrada = EntradaBd::getEntrada($entradaid);
        if (in_array($sesion->getId(), $entrada->getListaAutoresComentario())) {
            ComentarioBd::eliminar($comentario);

            if (isset($_GET['vuelta']) && $_GET['vuelta'] == 'detalle') {
                $this->vista = 'entrada/detalle';
                return EntradaBd::getEntrada($comentario->getEntrada());
            }
            $this->vista = 'entrada/lista';
            return EntradaBd::getEntradas();
        }
    } */
}
