<?php
// Tarjeta de una receta. Variables: $receta (Receta) y opcional $enlaceReceta (URL del detalle)
$enlaceReceta = $enlaceReceta ?? ("index.php?accion=detalle&id=" . (int) $receta->getId_receta());
$img = imagenReceta($receta);   // foto del panel, o archivo publico/img/recetas/<nombre-de-la-receta>.jpg
?>
<div class="card h-100 tarjeta-receta">
    <?php if ($img !== ""): ?>
        <img src="<?= e($img) ?>" class="card-img-top foto-receta" alt="<?= e($receta->getNombre()) ?>" loading="lazy">
    <?php else: ?>
        <div class="foto-receta foto-emoji" aria-hidden="true"><?= e($receta->getIcono()) ?></div>
    <?php endif; ?>
    <div class="card-body">
        <div class="small text-warning mb-1"><?= e(iconoPlato($receta->getTipo_plato())) ?> <?= e(etiquetaPlato($receta->getTipo_plato())) ?> · <?= e($receta->getCategoria() !== "" ? $receta->getCategoria() : "Sin categoría") ?></div>
        <h5 class="card-title"><?= e($receta->getNombre()) ?></h5>
        <p class="card-text small text-secondary"><?= e($receta->getDescripcion()) ?></p>
        <p class="mb-1 small">
            ⏱ <?= (int) $receta->getTiempo_minutos() ?> min ·
            <span class="badge text-bg-warning"><?= e(etiquetaDificultad($receta->getDificultad())) ?></span>
        </p>
        <?php if (isset($mostrarPorcentaje) && $mostrarPorcentaje): ?>
            <div class="progress mb-1" role="progressbar" aria-label="Ingredientes que tienes">
                <div class="progress-bar bg-success" style="width: <?= (int) $receta->getPorcentaje() ?>%"><?= (int) $receta->getPorcentaje() ?>%</div>
            </div>
            <?php if (!empty($receta->getUsados())): ?>
                <p class="small mb-1 usa-ingredientes">✔ Usa: <?= e(implode(", ", $receta->getUsados())) ?></p>
            <?php endif; ?>
            <p class="small mb-0">
                <?php if (empty($receta->getFaltantes())): ?>
                    <span class="text-success">✔ Tienes todo lo necesario</span>
                <?php else: ?>
                    <span class="text-danger">Te falta: <?= e(implode(", ", $receta->getFaltantes())) ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
        <a href="<?= e($enlaceReceta) ?>" class="btn btn-sm btn-gustoff w-100">Ver receta</a>
    </div>
</div>
