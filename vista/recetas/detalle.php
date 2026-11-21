<?php
// Pantalla 4 - Detalle de la receta (ingredientes y preparación).
// Variables: $receta, $ingredientes, $pasos, $misIngredientes
$titulo = $receta->getNombre();
$pagina = "inicio";
require __DIR__ . "/../plantilla/encabezado.php";
$img = imagenReceta($receta);

// Datos para generar el PDF de la receta en el navegador
$datosPdf = [
    "nombre"      => $receta->getNombre(),
    "descripcion" => $receta->getDescripcion(),
    "categoria"   => $receta->getCategoria(),
    "tiempo"      => (int) $receta->getTiempo_minutos(),
    "porciones"   => (int) $receta->getPorciones(),
    "dificultad"  => etiquetaDificultad($receta->getDificultad()),
    "ingredientes" => array_map(function ($i) {
        return trim(formatearCantidad($i["cantidad"]) . " " . ($i["unidad"] ?? "") . " " . $i["nombre"]) . ($i["opcional"] ? " (opcional)" : "");
    }, $ingredientes),
    "pasos" => array_column($pasos, "descripcion")
];
?>

<main class="container py-4">
    <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary mb-3 no-imprimir">← Volver</a>

    <?php if (!$receta->getActiva()): ?>
        <div class="alert alert-warning">Esta receta está <strong>desactivada</strong>: solo tú, como administrador, puedes verla.</div>
    <?php endif; ?>

    <div class="row g-4 align-items-start mb-3">
        <div class="col-lg-<?= $img !== "" ? "7" : "12" ?>">
            <div class="small text-warning mb-1"><?= e($receta->getIcono()) ?> <?= e($receta->getCategoria() !== "" ? $receta->getCategoria() : "Sin categoría") ?> · <?= e(etiquetaTipo($receta->getTipo_comida())) ?></div>
            <h1 class="h2"><?= e($receta->getNombre()) ?></h1>
            <p class="text-secondary"><?= e($receta->getDescripcion()) ?></p>
            <p>
                ⏱ <?= (int) $receta->getTiempo_minutos() ?> min · 🍽 <?= (int) $receta->getPorciones() ?> porciones ·
                <span class="badge text-bg-warning"><?= e(etiquetaDificultad($receta->getDificultad())) ?></span>
            </p>

            <div class="d-flex flex-wrap gap-2 no-imprimir">
                <button type="button" id="btnPdfReceta" class="btn btn-outline-gustoff">📄 Descargar PDF</button>
                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">🖨 Imprimir</button>
            </div>
        </div>
        <?php if ($img !== ""): ?>
            <div class="col-lg-5"><img src="<?= e($img) ?>" class="foto-detalle" alt="<?= e($receta->getNombre()) ?>"></div>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <h4>Ingredientes</h4>
            <ul class="list-group">
                <?php foreach ($ingredientes as $ingrediente): ?>
                    <?php
                    $tengo = $ingrediente["es_basico"] || in_array($ingrediente["nombre_normalizado"], $misIngredientes, true);
                    $cantidad = formatearCantidad($ingrediente["cantidad"]);
                    ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>
                            <?php if (!empty($misIngredientes)): ?><?= $tengo ? "✔" : "✖" ?><?php endif; ?>
                            <?= e(trim($cantidad . " " . $ingrediente["unidad"])) ?>
                            <?= e($ingrediente["nombre"]) ?>
                            <?php if ($ingrediente["opcional"]): ?>
                                <em class="text-secondary">(opcional)</em>
                            <?php endif; ?>
                        </span>
                        <?php if (!empty($misIngredientes) && !$tengo && !$ingrediente["opcional"]): ?>
                            <span class="badge text-bg-danger">Falta</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-7">
            <h4>Preparación</h4>
            <ol class="pasos">
                <?php foreach ($pasos as $paso): ?>
                    <li><?= e($paso["descripcion"]) ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</main>

<script>const RECETA_PDF = <?= json_encode($datosPdf, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<?php
$scripts = [
    "https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js",
    "publico/js/receta_pdf.js"
];
require __DIR__ . "/../plantilla/pie.php";
