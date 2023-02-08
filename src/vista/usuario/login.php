<?php
$datos = $datosParaVista['datos'];
$nombre = $datos !== null ? $datos['nombre'] : '';
$mensaje = $datos !== null ? $datos['mensaje'] : '';
?>
<div class="container">
    <h1>Inicia sesión</h1>

    <form action="index.php?controlador=usuario&accion=login" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
        </div>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
        </div>
        <p class="alert alert-danger"><?= $mensaje ?></p>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>