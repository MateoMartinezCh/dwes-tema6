<?php
$mensaje = $datosParaVista['datos'];

echo <<<END
    <h2 class='alert alert-primary'>$mensaje</h2>
END;
