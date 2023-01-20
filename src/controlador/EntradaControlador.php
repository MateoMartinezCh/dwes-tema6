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
        return null;
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
            return null;
            /*             return EntradaBd::getEntrada($entrada->id);
 */
        }
        //*OTRO TEMPORAL SIESTAMAL LE DEVOLVEREMOS DATOS ETCC
        $this->vista = 'entrada/nuevo';
        return null;
    }

    public function eliminar(): bool|null
    {
        return null;
    }
}
