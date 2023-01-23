<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;

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
        if (!$_POST) {

            $this->vista = 'entrada/nuevo';
            return null;
        }
        $entrada = Entrada::crearEntradaDesdePost($_POST);
        if ($entrada->esValida()) {
            $this->vista = 'entrada/detalle';
            $entrada->setId(EntradaBd::insertar($entrada));
            //* TEMPORAL
            return EntradaBd::getEntrada($entrada->getId());
        }
        //*OTRO TEMPORAL SIESTAMAL LE DEVOLVEREMOS DATOS ETCC
        $this->vista = 'entrada/nuevo';
        return null;
    }

    public function eliminar(): bool|null
    {
        $this->vista = 'entrada/eliminar';
        $id = $_GET && $_GET['id'] ? htmlspecialchars($_GET['id']) : null;
        if ($id !== null) {
            return EntradaBd::eliminar($id);
        } else {
            return false;
        }
    }
}
