<?php
// Catálogo de recetas con búsqueda y filtros.
// Variables: $recetas, $categorias, $filtros, $total, $pagina, $paginas, $consulta
$titulo = "Recetas";
$pagina_menu = "catalogo";
$paginaActual = $pagina;     // $pagina lo usa el encabezado para marcar el menú
$pagina = $pagina_menu;
require __DIR__ . "/../plantilla/encabezado.php";

// Enlace de paginación conservando los filtros
function enlacePagina($consulta, $n)
{
    $q = $consulta;
    $q["accion"] = "catalogo";
    $q["pagina"] = $n;
    return "index.php?" . http_build_query($q);
}
?>

<main class="container py-4">
    <h2 class="mb-3">Todas las recetas</h2>

    <!-- Filtros -->
    <form action="index.php" method="get" class="caja-oscura mb-3" novalidate>
        <input type="hidden" name="accion" value="catalogo">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-lg-3">
                <label class="form-label small" for="cQ">Nombre o ingrediente</label>
                <input type="search" id="cQ" name="q" class="form-control" maxlength="60" value="<?= e($filtros["q"]) ?>" placeholder="Ej: pollo, silpancho...">
            </div>
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="cCat">Categoría</label>
                <select id="cCat" name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= (int) $c["id_categoria"] ?>" <?= (int) $filtros["categoria"] === (int) $c["id_categoria"] ? "selected" : "" ?>><?= e($c["nombre"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="cPlato">Tipo de plato</label>
                <select id="cPlato" name="plato" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach (["sopa", "segundo", "ensalada", "desayuno", "postre", "snack"] as $p): ?>
                        <option value="<?= $p ?>" <?= $filtros["plato"] === $p ? "selected" : "" ?>><?= e(etiquetaPlato($p)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="cTipo">Momento</label>
                <select id="cTipo" name="tipo" class="form-select">
                    <option value="">Cualquiera</option>
                    <?php foreach (["desayuno", "almuerzo", "cena", "postre", "snack"] as $t): ?>
                        <option value="<?= $t ?>" <?= $filtros["tipo"] === $t ? "selected" : "" ?>><?= e(etiquetaTipo($t)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="cDif">Dificultad</label>
                <select id="cDif" name="dificultad" class="form-select">
                    <option value="">Cualquiera</option>
                    <?php foreach (["facil", "media", "dificil"] as $d): ?>
                        <option value="<?= $d ?>" <?= $filtros["dificultad"] === $d ? "selected" : "" ?>><?= e(etiquetaDificultad($d)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-lg-1">
                <label class="form-label small" for="cTiempo">Máx. min</label>
                <select id="cTiempo" name="tiempo" class="form-select">
                    <option value="0">—</option>
                    <?php foreach ([20, 30, 45, 60, 90] as $t): ?>
                        <option value="<?= $t ?>" <?= (int) $filtros["tiempo"] === $t ? "selected" : "" ?>><?= $t ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="cOrden">Ordenar por</label>
                <select id="cOrden" name="orden" class="form-select">
                    <option value="nombre" <?= $filtros["orden"] === "nombre" ? "selected" : "" ?>>Nombre</option>
                    <option value="rapidas" <?= $filtros["orden"] === "rapidas" ? "selected" : "" ?>>Más rápidas</option>
                    <option value="recientes" <?= $filtros["orden"] === "recientes" ? "selected" : "" ?>>Más recientes</option>
                </select>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
                <div class="form-check me-2">
                    <input class="form-check-input" type="checkbox" name="rapidas" value="1" id="cRapidas" <?= $filtros["rapidas"] ? "checked" : "" ?>>
                    <label class="form-check-label" for="cRapidas">⚡ Solo fáciles y rápidas (≤ 30 min)</label>
                </div>
                <button type="submit" class="btn btn-gustoff btn-sm">Aplicar filtros</button>
                <a href="index.php?accion=catalogo" class="btn btn-outline-secondary btn-sm">Limpiar</a>
            </div>
        </div>
    </form>

    <p class="small text-secondary"><?= (int) $total ?> receta(s) encontradas</p>

    <?php if (empty($recetas)): ?>
        <div class="alert alert-info">No hay recetas con esos filtros. Prueba con otra búsqueda.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($recetas as $receta): ?>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <?php include __DIR__ . "/../plantilla/tarjeta_receta.php"; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($paginas > 1): ?>
            <nav class="mt-4" aria-label="Paginación">
                <ul class="pagination justify-content-center flex-wrap">
                    <li class="page-item <?= $paginaActual <= 1 ? "disabled" : "" ?>">
                        <a class="page-link" href="<?= e(enlacePagina($consulta, $paginaActual - 1)) ?>">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $paginas; $i++): ?>
                        <li class="page-item <?= $i === $paginaActual ? "active" : "" ?>">
                            <a class="page-link" href="<?= e(enlacePagina($consulta, $i)) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $paginaActual >= $paginas ? "disabled" : "" ?>">
                        <a class="page-link" href="<?= e(enlacePagina($consulta, $paginaActual + 1)) ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
