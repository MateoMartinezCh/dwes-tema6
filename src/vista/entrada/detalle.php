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
    if ($sesion->haySesion() && $sesion->getId() == $entrada->getAutor()) {
        echo "<a href='index.php?controlador=entrada&accion=eliminar&id=$id' class='btn btn-danger'>Eliminar</a>";
    }
} else {
    echo "<p class='alert alert-danger'>No existe esta entrada</p>";
}
