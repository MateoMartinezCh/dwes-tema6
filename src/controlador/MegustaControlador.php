<?php

namespace dwesgram\controlador;

use dwesgram\modelo\Megusta;
use dwesgram\controlador\Controlador;
use dwesgram\modelo\MegustaBd;

class MegustaControlador extends Controlador
{

    public function nuevo(): Megusta|null
    {
        if (!$this->autenticado() || !$_GET) {
            header('Location:index.php');
            return null;
        }
        $megusta = Megusta::crearMegustaDesdeGet($_GET);
        $vista = isset($_GET['vuelta']) ? 'entrada/' . $_GET['vuelta'] : 'entrada/lista';
        if ($megusta->esValido()) {
            $this->vista = $vista;

            $megusta->setId(MegustaBd::insertar($megusta));
            return MegustaBd::getmegusta($megusta->getId());
        }
        //* SI ESTA MAL LE DEVOLVEMOS DATOS 
        $this->vista = $vista;
        return $megusta;
    }
}
