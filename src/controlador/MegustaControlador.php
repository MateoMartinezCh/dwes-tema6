<?php

namespace dwesgram\controlador;

use dwesgram\modelo\Megusta;
use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\MegustaBd;

class MegustaControlador extends Controlador
{

    public function nuevo(): Entrada|array|null
    {
        if (!$this->autenticado() || !$_GET) {
            header('Location:index.php');
            return null;
        }
        $megusta = Megusta::crearMegustaDesdeGet($_GET);
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
}
