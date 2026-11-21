<?php
// Administración de recetas: listado con búsqueda y filtros. Variables: $lista, $filtros, $categorias
$titulo = "Administrar recetas";
$pagina = "admin";
$seccion = "recetas";
require __DIR__ . "/../plantilla/encabezado.php";
$volver = "index.php?" . http_build_query(array_merge(["accion" => "admin_recetas"], array_filter($filtros, function ($v) { return $v !== ""; })));
?>

<main class="container py-4">
    <h2 class="mb-3">Administrar recetas</h2>
    <?php require __DIR__ . "/menu.php"; ?>

    <form action="index.php" method="get" class="caja-oscura mb-3" novalidate>
        <input type="hidden" name="accion" value="admin_recetas">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label small" for="aQ">Buscar por nombre</label>
                <input type="search" id="aQ" name="q" class="form-control" maxlength="60" value="<?= e($filtros["q"]) ?>">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label small" for="aCat">Categoría</label>
                <select id="aCat" name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <option value="sin" <?= $filtros["categoria"] === "sin" ? "selected" : "" ?>>Sin categoría</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= (int) $c["id_categoria"] ?>" <?= (string) $filtros["categoria"] === (string) $c["id_categoria"] ? "selected" : "" ?>><?= e($c["nombre"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small" for="aTipo">Tipo</label>
                <select id="aTipo" name="tipo" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach (["desayuno", "almuerzo", "cena", "postre", "snack"] as $t): ?>
                        <option value="<?= $t ?>" <?= $filtros["tipo"] === $t ? "selected" : "" ?>><?= e(etiquetaTipo($t)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small" for="aEstado">Estado</label>
                <select id="aEstado" name="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" <?= $filtros["estado"] === "1" ? "selected" : "" ?>>Activas</option>
                    <option value="0" <?= $filtros["estado"] === "0" ? "selected" : "" ?>>Desactivadas</option>
                </select>
            </div>
            <div class="col-6 col-md-1 d-grid"><button class="btn btn-gustoff" type="submit">Filtrar</button></div>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small text-secondary"><?= count($lista) ?> receta(s)</span>
        <a href="index.php?accion=admin_receta_form" class="btn btn-gustoff btn-sm">➕ Nueva receta</a>
    </div>

    <div class="table-responsive caja-oscura p-2">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr><th>Receta</th><th>Categoría</th><th>Plato</th><th>Dificultad</th><th>Min</th><th>Estado</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                <?php if (empty($lista)): ?>
                    <tr><td colspan="7" class="text-center text-secondary py-4">No hay recetas con esos filtros.</td></tr>
                <?php endif; ?>
                <?php foreach ($lista as $r): ?>
                    <tr>
                        <td>
                            <a class="text-white" href="index.php?accion=detalle&id=<?= (int) $r["id_receta"] ?>"><?= e($r["nombre"]) ?></a>
                            <?php if (imagenPorNombre($r["nombre"], $r["imagen_url"]) === ""): ?>
                                <span class="badge text-bg-secondary" title="Archivo esperado: publico/img/recetas/<?= e(slugReceta($r["nombre"])) ?>.jpg">Sin foto</span>
                            <?php endif; ?>
                        </td>
                        <td><?= e($r["categoria"] ?? "—") ?></td>
                        <td><?= e(etiquetaPlato($r["tipo_plato"])) ?></td>
                        <td><?= e(etiquetaDificultad($r["dificultad"])) ?></td>
                        <td><?= (int) $r["tiempo_minutos"] ?></td>
                        <td><?= $r["activa"] ? '<span class="badge text-bg-success">Activa</span>' : '<span class="badge text-bg-secondary">Desactivada</span>' ?></td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-light" href="index.php?accion=admin_receta_form&id=<?= (int) $r["id_receta"] ?>">Editar</a>
                            <form action="index.php?accion=admin_receta_estado" method="post" class="d-inline">
                                <?= campoToken() ?>
                                <input type="hidden" name="id_receta" value="<?= (int) $r["id_receta"] ?>">
                                <input type="hidden" name="volver" value="<?= e(urlSegura($volver)) ?>">
                                <button class="btn btn-sm btn-outline-warning" type="submit"><?= $r["activa"] ? "Desactivar" : "Activar" ?></button>
                            </form>
                            <form action="index.php?accion=admin_receta_eliminar" method="post" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar «<?= e(addslashes($r["nombre"])) ?>» definitivamente?');">
                                <?= campoToken() ?>
                                <input type="hidden" name="id_receta" value="<?= (int) $r["id_receta"] ?>">
                                <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
