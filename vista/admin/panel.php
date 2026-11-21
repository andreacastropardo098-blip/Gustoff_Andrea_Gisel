<?php
// Panel de administración - resumen.
$titulo = "Panel de administración";
$pagina = "admin";
$seccion = "panel";
require __DIR__ . "/../plantilla/encabezado.php";
$maxCat = 1;
foreach ($categorias as $c) { $maxCat = max($maxCat, (int) $c["total_todas"]); }
?>

<main class="container py-4">
    <h2 class="mb-3">Panel de administración</h2>
    <?php require __DIR__ . "/menu.php"; ?>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-4"><div class="card tarjeta-dato"><div class="numero"><?= $recetasEstado["activas"] ?></div><div>Recetas activas</div><small class="text-secondary"><?= $recetasEstado["inactivas"] ?> desactivadas</small></div></div>
        <div class="col-6 col-lg-4"><div class="card tarjeta-dato"><div class="numero"><?= $usuariosRol["usuario"] + $usuariosRol["administrador"] ?></div><div>Usuarios</div><small class="text-secondary"><?= $usuariosRol["administrador"] ?> administrador(es)</small></div></div>
        <div class="col-6 col-lg-4"><div class="card tarjeta-dato"><div class="numero"><?= $totalIngredientes ?></div><div>Ingredientes</div><small class="text-secondary">en el sistema</small></div></div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="caja-oscura h-100">
                <h3 class="h5">Recetas por categoría</h3>
                <?php foreach ($categorias as $c): ?>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small"><span><?= e($c["icono"]) ?> <?= e($c["nombre"]) ?></span><span><?= (int) $c["total_todas"] ?></span></div>
                        <div class="barra-cat"><span style="width: <?= round(((int) $c["total_todas"]) * 100 / $maxCat) ?>%"></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex flex-wrap gap-2">
        <a href="index.php?accion=admin_receta_form" class="btn btn-gustoff">➕ Nueva receta</a>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
