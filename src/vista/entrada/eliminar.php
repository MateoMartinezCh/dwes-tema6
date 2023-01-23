<?php

$resultado = $datosParaVista['datos'];

if ($resultado) {
    echo "<h3>Entrada eliminada correctamente</h3>";
} else {
    echo "<h3>La entrada no se ha podido eliminar</h3>";
}

echo <<<END
    <p><a href="index.php?controlador=entrada&accion=lista">Volver</a></p>
END;
