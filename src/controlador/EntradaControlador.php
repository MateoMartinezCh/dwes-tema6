<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;
use dwesgram\utility\Sesion;

class EntradaControlador extends Controlador
{

    public function lista(): array
    {
        $this->vista = 'entrada/lista';
        return EntradaBD::getEntradas();
    }

    public function detalle(): Entrada|null
    {
        $this->vista = 'entrada/detalle';
        return EntradaBd::getEntrada(htmlspecialchars(trim($_GET['id'])));
    }

    public function nuevo(): Entrada|null
    {
        if (!$this->autenticado()) {
            header('Location:index.php');
            return null;
        }
        if (!$_POST) {

            $this->vista = 'entrada/nuevo';
            return null;
        }
        $entrada = Entrada::crearEntradaDesdePost($_POST);
        $entrada->anyadirImagenDesdeFile($_FILES);

        if ($entrada->esValida()) {
            $this->vista = 'entrada/detalle';

            $entrada->setId(EntradaBd::insertar($entrada));
            return EntradaBd::getEntrada($entrada->getId());
        }
        //* SI ESTA MAL LE DEVOLVEMOS DATOS 
        $this->vista = 'entrada/nuevo';
        return $entrada;
    }

    public function eliminar(): bool|null
    {
        if (!$this->autenticado()) {
            header('Location:index.php');
            return null;
        }

        $this->vista = 'entrada/eliminar';
        $id = $_GET && $_GET['id'] ? htmlspecialchars($_GET['id']) : null;
        $sesion = new Sesion();

        if ($id !== null) {
            $entrada = EntradaBd::getEntrada($id);
            if ($sesion->getId() == $entrada->getAutor()) {
                return EntradaBd::eliminar($id);
            }
            return false;
        } else {
            return false;
        }
    }
}
