<?php

use dwesgram\modelo\UsuarioBd;

if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $texto = $entrada->getTexto();
    $img = $entrada->getImagen();
    $id = $entrada->getId();
    $dt = new \DateTime('@' . $entrada->getCreado());
    $dtstr = $dt->format('r');
    $autor = UsuarioBd::getUsuarioPorId($entrada->getAutor());
    echo <<<END
        <h1>{$autor->getNombre()} escribió</h1>
        <p>$texto</p>
        <img src="$img" class="img-fluid">
        <p><small>$dtstr</small></p>
    END;
    if ($sesion->haySesion()) {
        //si el autor es el mismo que el id de la entrada, saldrá el botón de eliminar
        if ($sesion->getId() == $entrada->getAutor()) {

            echo "<a href='index.php?controlador=entrada&accion=eliminar&id={$entrada->getId()}' class='btn btn-danger'>Eliminar</a>";

            //si no es el mismo autor pero ya le ha dado a me gusta le saldrá el corazón lleno.
        } else if (in_array($sesion->getId(), $entrada->getListaAutoresMeGusta())) {
            echo "<i class='bi bi-heart-fill'></i>";
            echo "<p>({$entrada->numAutores()} Me gusta)</p>";
        }
        //si no le ha dado a megusta entonces saldrá el corazón vacío y podrá darle a megusta
        else {
            echo "<a href='index.php?controlador=megusta&accion=nuevo&entrada={$entrada->getId()}&usuario={$sesion->getId()}&vuelta=detalle'><i class='bi bi-heart'></i></a>";
            echo "<p>({$entrada->numAutores()} Me gusta)</p>";
        }
    } else {
        echo "<i class='bi bi-heart'></i>";
        /*             echo "<i class='bi bi-heart-fill'></i>";*/
        echo "<p>({$entrada->numAutores()} Me gusta)</p>";
    }
} else {
    echo "<p class='alert alert-danger'>No existe esta entrada</p>";
}
