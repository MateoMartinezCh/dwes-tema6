<?php
if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $texto = $entrada->getTexto();
    $img = $entrada->getImagen();
    $id = $entrada->getId();
    $dt = new \DateTime('@' . $entrada->getCreado());
    $dtstr = $dt->format('r');
    echo <<<END
        <p>$texto</p>
        <img src="$img"/>
        <p><small>$dtstr</small></p>
    END;
    if ($sesion->haySesion()) {

        echo "<a href='index.php?controlador=entrada&accion=eliminar&id=$id' class='btn btn-danger'>Eliminar</a>";
    }
} else {
    echo "<p class='alert alert-danger'>No existe esta entrada</p>";
}
