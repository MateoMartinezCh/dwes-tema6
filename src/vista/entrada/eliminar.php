<?php

$resultado = $datosParaVista['datos'];

if ($resultado) {
    echo "<h3 class='alert alert-primary'>Entrada eliminada correctamente</h3>";
} else {
    echo "<h3 class='alert alert-danger'>La entrada no se ha podido eliminar</h3>";
}

echo <<<END
    <p><a href="index.php?controlador=entrada&accion=lista" class="alert alert-succes">Volver</a></p>
END;
