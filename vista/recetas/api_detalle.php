<?php
// Receta internacional obtenida desde TheMealDB. Variable: $meal
$titulo = $meal["nombre"];
$pagina = "inicio";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<main class="container py-4">
    <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary mb-3">← Volver</a>

    <div class="row g-4">
        <div class="col-md-5">
            <?php if ($meal["imagen"] !== ""): ?>
                <img src="<?= e($meal["imagen"]) ?>" class="foto-detalle mb-3" alt="<?= e($meal["nombre"]) ?>">
            <?php endif; ?>
            <h4>Ingredientes</h4>
            <ul class="list-group">
                <?php foreach ($meal["ingredientes"] as $ing): ?>
                    <li class="list-group-item"><?= e(trim($ing["medida"] . " " . $ing["nombre"])) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-7">
            <div class="small text-warning mb-1">🌎 Receta internacional · <?= e($meal["categoria"]) ?> · <?= e($meal["origen"]) ?></div>
            <h1 class="h2"><?= e($meal["nombre"]) ?></h1>
            <p class="small text-secondary">Receta obtenida de TheMealDB (API pública). Las instrucciones están en inglés.</p>
            <h4>Preparación</h4>
            <p style="white-space: pre-line;"><?= e($meal["instrucciones"]) ?></p>
            <?php if ($meal["youtube"] !== "" && preg_match('#^https://(www\.)?youtube\.com/#', $meal["youtube"])): ?>
                <a href="<?= e($meal["youtube"]) ?>" target="_blank" rel="noopener" class="btn btn-outline-gustoff">▶ Ver video en YouTube</a>
            <?php endif; ?>
            <a href="index.php?accion=api_azar" class="btn btn-gustoff ms-1">🎲 Otra receta al azar</a>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
