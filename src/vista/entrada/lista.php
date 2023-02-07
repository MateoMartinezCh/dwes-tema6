<?php

use dwesgram\modelo\UsuarioBd;

if (!empty($datosParaVista['datos'])) {
    echo "<h3>Esta es la lista de entradas:</h3>";
    echo "<hr>";
    echo '<div class="grid-container">';
    foreach ($datosParaVista['datos'] as $entrada) {
        $autor = UsuarioBd::getUsuarioPorId($entrada->getAutor());

        echo <<<END
            <div class="card grid-item" style="width: 18rem;">
                <img class="card-img-top" src="{$entrada->getImagen()}" alt="/src/img/alt.webp">
                <div class="card-body">
                    <h5 class="card-text">{$autor->getNombre()} escribió</h5>
                    <p class="card-text">{$entrada->getTexto()}</p>
                    <a  href="index.php?controlador=entrada&accion=detalle&id={$entrada->getId()} " class="btn btn-primary">Detalles</a>
        END;
        if ($sesion->haySesion()) {
            //si el autor es el mismo que el id de la entrada, saldrá el botón de eliminar
            if ($sesion->getId() == $entrada->getAutor()) {

                echo "<a href='index.php?controlador=entrada&accion=eliminar&id={$entrada->getId()}' class='btn btn-danger'>Eliminar</a>";
                if ($entrada->numAutores() != 0) {
                    echo "<i class='bi bi-heart-fill'></i>";
                } else {
                    echo "<i class='bi bi-heart'></i>";
                }
                /*             echo "<i class='bi bi-heart-fill'></i>";*/
                echo "<p>({$entrada->numAutores()} Me gusta)</p>";
                //si no es el mismo autor pero ya le ha dado a me gusta le saldrá el corazón lleno.
            } else if (in_array($sesion->getId(), $entrada->getListaAutoresMeGusta())) {
                echo "<a href='index.php?controlador=megusta&accion=quitar&entrada={$entrada->getId()}&usuario={$sesion->getId()}&vuelta=lista'><i class='bi bi-heart-fill'></i></a>";
                echo "<p>({$entrada->numAutores()} Me gusta)</p>";
            }
            //si no le ha dado a megusta entonces saldrá el corazón vacío y podrá darle a megusta
            else {
                echo "<a href='index.php?controlador=megusta&accion=nuevo&entrada={$entrada->getId()}&usuario={$sesion->getId()}&vuelta=lista'><i class='bi bi-heart'></i></a>";
                echo "<p>({$entrada->numAutores()} Me gusta)</p>";
                /* foreach ($entrada->getListaAutoresMeGusta() as $autor) {
                    echo "$autor";
                } */
            }
        } else {
            if ($entrada->numAutores() != 0) {
                echo "<i class='bi bi-heart-fill'></i>";
            } else {
                echo "<i class='bi bi-heart'></i>";
            }
            /*             echo "<i class='bi bi-heart-fill'></i>";*/
            echo "<p>({$entrada->numAutores()} Me gusta)</p>";
        }
        echo <<<END
                </div>
            </div>
        END;
    }
    echo "</div>";
} else {
    echo "<h3 class='alert alert-primary'>Tu lista de cosas por hacer está vacía</h3>";
}
