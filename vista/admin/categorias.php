<?php
// CRUD de categorías. Variables: $categorias, $editar
$titulo = "Categorías";
$pagina = "admin";
$seccion = "categorias";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<main class="container py-4">
    <h2 class="mb-3">Categorías</h2>
    <?php require __DIR__ . "/menu.php"; ?>

    <div class="row g-3">
        <div class="col-lg-4">
            <form action="index.php?accion=admin_categoria_guardar" method="post" class="caja-oscura" data-validar novalidate>
                <?= campoToken() ?>
                <input type="hidden" name="id_categoria" value="<?= (int) ($editar["id_categoria"] ?? 0) ?>">
                <h3 class="h5"><?= $editar ? "Editar categoría" : "Nueva categoría" ?></h3>
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" minlength="2" maxlength="60" required value="<?= e($editar["nombre"] ?? "") ?>">
                    <div class="invalid-feedback">El nombre debe tener entre 2 y 60 caracteres.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="icono">Ícono (un emoji)</label>
                    <input type="text" class="form-control" id="icono" name="icono" maxlength="4" placeholder="🍗" value="<?= e($editar["icono"] ?? "") ?>">
                </div>
                <button type="submit" class="btn btn-gustoff"><?= $editar ? "Guardar cambios" : "Crear categoría" ?></button>
                <?php if ($editar): ?><a href="index.php?accion=admin_categorias" class="btn btn-outline-secondary">Cancelar</a><?php endif; ?>
            </form>
        </div>

        <div class="col-lg-8">
            <div class="table-responsive caja-oscura p-2">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th></th><th>Categoría</th><th>Recetas</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        <?php foreach ($categorias as $c): ?>
                            <tr>
                                <td class="fs-4"><?= e($c["icono"]) ?></td>
                                <td><?= e($c["nombre"]) ?></td>
                                <td><?= (int) $c["total_todas"] ?></td>
                                <td class="text-end text-nowrap">
                                    <a class="btn btn-sm btn-outline-light" href="index.php?accion=admin_categorias&editar=<?= (int) $c["id_categoria"] ?>">Editar</a>
                                    <form action="index.php?accion=admin_categoria_eliminar" method="post" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar la categoría «<?= e(addslashes($c["nombre"])) ?>»? Sus recetas quedarán sin categoría.');">
                                        <?= campoToken() ?>
                                        <input type="hidden" name="id_categoria" value="<?= (int) $c["id_categoria"] ?>">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
