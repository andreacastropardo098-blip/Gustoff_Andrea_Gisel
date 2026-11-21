<?php
// Pantalla 3 - Qué puedo cocinar.
// Variables: $ingredientes, $todas, $recetas, $conteo, $platoElegido, $filtros, $filtrosIgnorados,
//            $desconocidos, $destacadas, $consultaIng, $consultaFiltros, $api
$titulo = "Qué puedo cocinar";
$pagina = "inicio";
require __DIR__ . "/../plantilla/encabezado.php";
$mostrarPorcentaje = true;

// Enlace de la receta conservando los ingredientes (para marcar ✔ / ✖ en el detalle)
function enlaceDetalleConIng($receta, $ingredientes)
{
    $url = "index.php?accion=detalle&id=" . (int) $receta->getId_receta();
    foreach ($ingredientes as $ing) {
        $url .= "&ing[]=" . urlencode($ing);
    }
    return $url;
}

// Se agrupan por qué tan completas están
$niveles = [
    "listas"  => ["titulo" => "✅ Puedes prepararlas ya", "detalle" => "tienes todos los ingredientes", "lista" => []],
    "pocas"   => ["titulo" => "🛒 Te faltan pocos ingredientes", "detalle" => "tienes más de la mitad", "lista" => []],
    "mas"     => ["titulo" => "💡 Más ideas con tus ingredientes", "detalle" => "usan alguno de los que tienes", "lista" => []],
];
foreach ($recetas as $r) {
    $p = (int) $r->getPorcentaje();
    $niveles[$p >= 100 ? "listas" : ($p >= 60 ? "pocas" : "mas")]["lista"][] = $r;
}
?>

<main class="container py-4">
    <h2 class="mb-1">Esto puedes cocinar</h2>
    <p class="text-secondary mb-2">
        Con: <?php foreach ($ingredientes as $ing): ?><span class="badge chip-ingrediente"><?= e($ing) ?></span><?php endforeach; ?>
        <a href="index.php" class="text-warning ms-1">Cambiar ingredientes</a>
    </p>

    <?php if ($filtrosIgnorados): ?>
        <div class="alert alert-info">Con esos filtros no había recetas, así que te mostramos todas las que usan tus ingredientes.</div>
    <?php endif; ?>

    <?php if (!empty($desconocidos) && !empty($todas)): ?>
        <p class="small text-secondary">Todavía no tenemos recetas con: <strong><?= e(implode(", ", $desconocidos)) ?></strong>. Las demás sí se usaron para buscar.</p>
    <?php endif; ?>

    <?php if (empty($todas)): ?>
        <!-- Sin coincidencias: nunca se muestra un error, sino ideas -->
        <div class="caja-oscura my-4">
            <h3 class="h5">Todavía no tenemos recetas con <?= e(implode(", ", $ingredientes)) ?></h3>
            <p class="mb-2">Prueba con ingredientes más comunes (papa, cebolla, huevo, tomate, arroz, fideo, pollo, carne...) o mira estas ideas:</p>
            <a href="index.php" class="btn btn-gustoff btn-sm">Probar con otros ingredientes</a>
            <a href="index.php?accion=catalogo" class="btn btn-outline-gustoff btn-sm">Ver todas las recetas</a>
            <a href="index.php?accion=api_azar" class="btn btn-outline-gustoff btn-sm">Sorpréndeme</a>
        </div>
        <?php if (!empty($destacadas)): ?>
            <h3 class="h5 mb-3">Recetas destacadas</h3>
            <div class="row g-3">
                <?php $mostrarPorcentaje = false; ?>
                <?php foreach ($destacadas as $receta): ?>
                    <div class="col-md-6 col-lg-4"><?php include __DIR__ . "/../plantilla/tarjeta_receta.php"; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- Tipo de plato: sopas, segundos, ensaladas... con la cantidad de recetas -->
        <div class="fila-platos" role="navigation" aria-label="Tipo de plato">
            <a class="chip-plato <?= $platoElegido === "" ? "activo" : "" ?>" href="index.php?accion=buscar<?= $consultaIng . $consultaFiltros ?>">
                Todo <span class="cuenta"><?= count($todas) ?></span>
            </a>
            <?php foreach ($conteo as $plato => $cuantas): ?>
                <a class="chip-plato <?= $platoElegido === $plato ? "activo" : "" ?> <?= $cuantas === 0 ? "vacio" : "" ?>"
                   href="index.php?accion=buscar<?= $consultaIng . $consultaFiltros ?>&plato=<?= e($plato) ?>">
                    <?= e(iconoPlato($plato)) ?> <?= e(etiquetaPlato($plato)) ?> <span class="cuenta"><?= (int) $cuantas ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Filtros opcionales -->
        <form action="index.php" method="get" class="caja-oscura mb-3 py-3" novalidate>
            <input type="hidden" name="accion" value="buscar">
            <input type="hidden" name="plato" value="<?= e($platoElegido) ?>">
            <?php foreach ($ingredientes as $ing): ?><input type="hidden" name="ingredientes[]" value="<?= e($ing) ?>"><?php endforeach; ?>
            <div class="row g-2 align-items-end">
                <div class="col-6 col-md-3">
                    <label class="form-label small" for="rTipo">Momento del día</label>
                    <select id="rTipo" name="tipo" class="form-select form-select-sm">
                        <option value="">Cualquiera</option>
                        <?php foreach (["desayuno", "almuerzo", "cena", "postre", "snack"] as $t): ?>
                            <option value="<?= $t ?>" <?= $filtros["tipo"] === $t ? "selected" : "" ?>><?= e(etiquetaTipo($t)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small" for="rDif">Dificultad</label>
                    <select id="rDif" name="dificultad" class="form-select form-select-sm">
                        <option value="">Cualquiera</option>
                        <?php foreach (["facil", "media", "dificil"] as $d): ?>
                            <option value="<?= $d ?>" <?= $filtros["dificultad"] === $d ? "selected" : "" ?>><?= e(etiquetaDificultad($d)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small" for="rTiempo">Tiempo máx.</label>
                    <select id="rTiempo" name="tiempo" class="form-select form-select-sm">
                        <option value="0">Sin límite</option>
                        <?php foreach ([20, 40, 60, 90] as $t): ?>
                            <option value="<?= $t ?>" <?= (int) $filtros["tiempo"] === $t ? "selected" : "" ?>><?= $t ?> min</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="solo_completas" value="1" id="rCompletas" <?= $filtros["solo_completas"] ? "checked" : "" ?>>
                        <label class="form-check-label small" for="rCompletas">Solo las que ya puedo preparar</label>
                    </div>
                </div>
                <div class="col-12 col-md-2 d-grid"><button type="submit" class="btn btn-gustoff btn-sm">Aplicar</button></div>
            </div>
        </form>

        <?php if (empty($recetas)): ?>
            <div class="alert alert-info">
                No hay <?= e(mb_strtolower(etiquetaPlato($platoElegido))) ?> con esos ingredientes.
                <a href="index.php?accion=buscar<?= $consultaIng . $consultaFiltros ?>" class="alert-link">Ver todo lo que puedes cocinar</a>.
            </div>
        <?php else: ?>
            <p class="small text-secondary"><?= count($recetas) ?> receta(s), de la más completa a la menos completa.</p>
            <?php foreach ($niveles as $nivel): ?>
                <?php if (empty($nivel["lista"])) { continue; } ?>
                <h3 class="h5 titulo-nivel"><?= e($nivel["titulo"]) ?> <small>(<?= count($nivel["lista"]) ?> · <?= e($nivel["detalle"]) ?>)</small></h3>
                <div class="row g-3">
                    <?php foreach ($nivel["lista"] as $receta): ?>
                        <?php $enlaceReceta = enlaceDetalleConIng($receta, $ingredientes); ?>
                        <div class="col-md-6 col-lg-4">
                            <?php include __DIR__ . "/../plantilla/tarjeta_receta.php"; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Ideas internacionales desde la API TheMealDB -->
    <?php if (!empty($api["recetas"])): ?>
        <hr class="my-5">
        <h3 class="h4">🌎 Ideas internacionales con «<?= e($api["ingrediente"]) ?>»</h3>
        <p class="small text-secondary">Recetas de TheMealDB (en inglés), una API pública de recetas.</p>
        <div class="row g-3">
            <?php foreach ($api["recetas"] as $m): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="index.php?accion=api_detalle&id=<?= e($m["idMeal"]) ?>" class="text-decoration-none">
                        <div class="card h-100 tarjeta-receta">
                            <img src="<?= e($m["strMealThumb"]) ?>/preview" class="card-img-top" alt="<?= e($m["strMeal"]) ?>" loading="lazy">
                            <div class="card-body p-2"><small class="text-white"><?= e($m["strMeal"]) ?></small></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
