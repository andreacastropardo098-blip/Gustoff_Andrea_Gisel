<?php
// Crear / editar una receta. Variables: $datos, $ingredientes, $pasos, $errores, $categorias, $sugerencias, $tipos
$titulo = $datos["id_receta"] ? "Editar receta" : "Nueva receta";
$pagina = "admin";
$seccion = "recetas";
require __DIR__ . "/../plantilla/encabezado.php";

$imagenActual = $datos["imagen_url"];
$esEnlace = (bool) preg_match('#^https?://#i', $imagenActual);
?>

<main class="container py-4">
    <h2 class="mb-3"><?= e($titulo) ?></h2>
    <?php require __DIR__ . "/menu.php"; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <strong>Revisa estos datos:</strong>
            <ul class="mb-0"><?php foreach ($errores as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form action="index.php?accion=admin_receta_guardar" method="post" enctype="multipart/form-data" id="formReceta" data-validar novalidate>
        <?= campoToken() ?>
        <input type="hidden" name="id_receta" value="<?= (int) $datos["id_receta"] ?>">

        <div class="caja-oscura mb-3">
            <h3 class="h5 mb-3">Datos generales</h3>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label" for="nombre">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" minlength="3" maxlength="120" required value="<?= e($datos["nombre"]) ?>">
                    <div class="invalid-feedback">El nombre debe tener entre 3 y 120 caracteres.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="id_categoria">Categoría</label>
                    <select class="form-select" id="id_categoria" name="id_categoria">
                        <option value="0">Sin categoría</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= (int) $c["id_categoria"] ?>" <?= (int) $datos["id_categoria"] === (int) $c["id_categoria"] ? "selected" : "" ?>><?= e($c["nombre"]) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="descripcion">Descripción corta</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="255" value="<?= e($datos["descripcion"]) ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="tipo_plato">Tipo de plato *</label>
                    <select class="form-select" id="tipo_plato" name="tipo_plato" required>
                        <?php foreach ($platos as $p): ?>
                            <option value="<?= $p ?>" <?= $datos["tipo_plato"] === $p ? "selected" : "" ?>><?= e(iconoPlato($p)) ?> <?= e(etiquetaPlato($p)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="tipo_comida">Momento del día *</label>
                    <select class="form-select" id="tipo_comida" name="tipo_comida" required>
                        <?php foreach ($tipos as $t): ?>
                            <option value="<?= $t ?>" <?= $datos["tipo_comida"] === $t ? "selected" : "" ?>><?= e(etiquetaTipo($t)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="dificultad">Dificultad *</label>
                    <select class="form-select" id="dificultad" name="dificultad" required>
                        <?php foreach (["facil", "media", "dificil"] as $d): ?>
                            <option value="<?= $d ?>" <?= $datos["dificultad"] === $d ? "selected" : "" ?>><?= e(etiquetaDificultad($d)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="tiempo_minutos">Tiempo (minutos) *</label>
                    <input type="number" class="form-control" id="tiempo_minutos" name="tiempo_minutos" min="1" max="1440" required value="<?= e($datos["tiempo_minutos"]) ?>">
                    <div class="invalid-feedback">Entre 1 y 1440 minutos.</div>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="porciones">Porciones *</label>
                    <input type="number" class="form-control" id="porciones" name="porciones" min="1" max="100" required value="<?= e($datos["porciones"]) ?>">
                    <div class="invalid-feedback">Entre 1 y 100 porciones.</div>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="activa" name="activa" value="1" <?= $datos["activa"] ? "checked" : "" ?>>
                        <label class="form-check-label" for="activa">Receta activa (visible para el público)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="caja-oscura mb-3">
            <h3 class="h5 mb-3">Foto de la receta (opcional)</h3>
            <?php if ($imagenActual !== ""): ?>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="<?= e($imagenActual) ?>" alt="Foto actual" style="height: 80px; border-radius: .5rem;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="quitar_imagen" value="1" id="quitar_imagen">
                        <label class="form-check-label" for="quitar_imagen">Quitar la foto actual</label>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="imagen">Subir archivo (JPG, PNG o WEBP, máx. 2 MB)</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="imagen_enlace">…o pegar un enlace de imagen</label>
                    <input type="url" class="form-control" id="imagen_enlace" name="imagen_enlace" maxlength="255" placeholder="https://..." value="<?= $esEnlace ? e($imagenActual) : "" ?>">
                    <div class="invalid-feedback">Escribe un enlace válido que empiece con http:// o https://</div>
                </div>
            </div>
        </div>

        <div class="caja-oscura mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="h5 mb-0">Ingredientes *</h3>
                <button type="button" class="btn btn-sm btn-outline-warning" id="btnAgregarIngrediente">➕ Agregar ingrediente</button>
            </div>
            <p class="small text-secondary">Cantidad y unidad son opcionales (ej.: «sal» → «al gusto»). Los ingredientes opcionales no cuentan para el porcentaje de coincidencia.</p>
            <datalist id="listaIngredientesSugeridos">
                <?php foreach ($sugerencias as $s): ?><option value="<?= e($s) ?>"><?php endforeach; ?>
            </datalist>
            <div id="contenedorIngredientes">
                <?php foreach ($ingredientes as $ing): ?>
                    <div class="row g-2 mb-2 fila-ingrediente">
                        <div class="col-12 col-md-4"><input type="text" class="form-control" name="ing_nombre[]" list="listaIngredientesSugeridos" maxlength="80" placeholder="Ingrediente" value="<?= e($ing["nombre"]) ?>"></div>
                        <div class="col-4 col-md-2"><input type="number" step="0.01" min="0" max="99999" class="form-control" name="ing_cantidad[]" placeholder="Cantidad" value="<?= e($ing["cantidad"]) ?>"></div>
                        <div class="col-8 col-md-3"><input type="text" class="form-control" name="ing_unidad[]" maxlength="30" placeholder="Unidad (g, tazas...)" value="<?= e($ing["unidad"]) ?>"></div>
                        <div class="col-8 col-md-2">
                            <select class="form-select" name="ing_opcional[]">
                                <option value="0" <?= !$ing["opcional"] ? "selected" : "" ?>>Necesario</option>
                                <option value="1" <?= $ing["opcional"] ? "selected" : "" ?>>Opcional</option>
                            </select>
                        </div>
                        <div class="col-4 col-md-1 d-grid"><button type="button" class="btn btn-outline-danger btn-quitar-fila" aria-label="Quitar ingrediente">✕</button></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-danger small" id="errorIngredientes" hidden>Agrega al menos un ingrediente con nombre.</div>
        </div>

        <div class="caja-oscura mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="h5 mb-0">Pasos de preparación *</h3>
                <button type="button" class="btn btn-sm btn-outline-warning" id="btnAgregarPaso">➕ Agregar paso</button>
            </div>
            <div id="contenedorPasos">
                <?php foreach ($pasos as $n => $texto): ?>
                    <div class="row g-2 mb-2 fila-paso">
                        <div class="col-auto pt-2"><span class="badge text-bg-warning numero-paso"><?= $n + 1 ?></span></div>
                        <div class="col"><textarea class="form-control" name="pasos[]" rows="2" maxlength="500" placeholder="Describe este paso"><?= e($texto) ?></textarea></div>
                        <div class="col-auto"><button type="button" class="btn btn-outline-danger btn-quitar-fila" aria-label="Quitar paso">✕</button></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-danger small" id="errorPasos" hidden>Agrega al menos un paso (mínimo 5 caracteres).</div>
        </div>

        <a href="index.php?accion=admin_recetas" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-gustoff">💾 Guardar receta</button>
    </form>
</main>

<?php
$scripts = ["publico/js/receta_form.js"];
require __DIR__ . "/../plantilla/pie.php";
