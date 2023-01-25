<?php

/**
 * TODO - Aquí irá la lista de entradas del servidor.
 */
if (!empty($datosParaVista['datos'])) {
    echo "<h3>Esta es la lista de entradas:</h3>";
    echo "<hr>";
    /*     echo "<div style='display:grid; grid-template-columns:repeat(4,1fr);'>";
 */
    foreach ($datosParaVista['datos'] as $entrada) {

        echo <<<END
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{$entrada->getImagen()}" alt="/src/img/alt.webp">
                <div class="card-body">
                    <p class="card-text">{$entrada->getTexto()}</p>
                    <a  href="index.php?controlador=entrada&accion=detalle&id={$entrada->getId()} " class="btn btn-primary">Detalles</a>
        END;
        if ($sesion->haySesion()) {

            echo "<a href='index.php?controlador=entrada&accion=eliminar&id={$entrada->getId()}' class='btn btn-danger'>Eliminar</a>";
        }
        echo <<<END
                </div>
            </div>
        END;
    }
} else {
    echo "<h3 class='alert alert-primary'>Tu lista de cosas por hacer está vacía</h3>";
}
