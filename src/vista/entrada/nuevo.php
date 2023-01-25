<?php
$entrada = $datosParaVista['datos'];

$errores = $entrada ? $entrada->getErrores() : [];
?>
<div class="container">
    <h1>Nueva entrada</h1>
    <form action="index.php?controlador=entrada&accion=nuevo" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="texto" class="form-label">
                ¿En qué estás pensando? Tienes 128 caracteres para plasmarlo... el resto se ignorará
            </label>
            <textarea class="form-control" name="texto" id="texto" rows="3" placeholder="Escribe aquí el texto"></textarea>
            <?php
            if (isset($errores['texto']) && $errores['texto'] !== null) {
                echo "<p class='alert alert-danger'>{$errores['texto']}</p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="imagen">Selecciona una imagen para acompañar a tu entrada</label>
            <input class="form-control" type="file" name="imagen" id="imagen">
            <?php
            if (isset($errores['imagen']) && $errores['imagen'] !== null) {
                echo "<p class='alert alert-danger'>{$errores['imagen']}</p>";
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
</div>