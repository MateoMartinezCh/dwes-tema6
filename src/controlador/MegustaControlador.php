<?php

namespace dwesgram\controlador;

use dwesgram\modelo\Megusta;
use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\MegustaBd;
use dwesgram\utility\Sesion;

class MegustaControlador extends Controlador
{

    public function nuevo(): Entrada|array|null
    {
        if (!$this->autenticado() || !$_GET) {
            header('Location:index.php');
            return null;
        }
        $megusta = Megusta::crearMegustaDesdeGet($_GET);
        $entrada = EntradaBd::getEntrada($megusta->getEntrada());
        $sesion = new Sesion();
        if ($entrada->getAutor() != $sesion->getId()) {

            if ($megusta->esValido()) {
                $megusta->setId(MegustaBd::insertar($megusta));

                if (isset($_GET['vuelta']) && $_GET['vuelta'] == 'detalle') {
                    $this->vista = 'entrada/detalle';
                    return EntradaBd::getEntrada($megusta->getEntrada());
                }
                $this->vista = 'entrada/lista';
                return EntradaBd::getEntradas();
            }
        }
        header('Location:index.php');
        return null;
    }
    public function quitar(): Entrada|array|null
    {
        if (!$this->autenticado() || !$_GET) {
            header('Location:index.php');
            return null;
        }
        /** 
         * !POSIBLE ERROR TAL VEZ PUEDE QUITAR ME GUSTA UN NO AUTORIZADO
         * isset($_GET['usuario']) || $_GET['usuario'] !== $sesion->getId() */
        $sesion = new Sesion();
        $megusta = Megusta::crearMegustaDesdeGet($_GET);
        $entradaid = $megusta->getEntrada();
        $entrada = EntradaBd::getEntrada($entradaid);
        if (in_array($sesion->getId(), $entrada->getListaAutoresMeGusta()) && $entrada->getAutor() != $sesion->getId()) {
            MegustaBd::eliminar($megusta);

            if (isset($_GET['vuelta']) && $_GET['vuelta'] == 'detalle') {
                $this->vista = 'entrada/detalle';
                return EntradaBd::getEntrada($megusta->getEntrada());
            }
            $this->vista = 'entrada/lista';
            return EntradaBd::getEntradas();
        }
        header('Location:index.php');
        return null;
    }
}
