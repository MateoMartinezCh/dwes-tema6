<?php
if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $texto = $entrada->getTexto();
    $img = $entrada->getImagen();
    $dt = new \DateTime('@' . $entrada->getCreado());
    $dtstr = $dt->format('r');
    echo <<<END
        <p>$texto</p>
        <img src="$img"/>
        <p><small>$dtstr</small></p>
    END;
} else {
    echo "<p class='alert alert-danger'>No existe esta entrada</p>";
}
