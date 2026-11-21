<?php
// Pantalla 1 - Inicio. Variables: $categorias, $destacadas
$titulo = "Inicio";
$pagina = "inicio";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<!-- HERO: fondo de Sanji (en el body) y el platillo a la derecha -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 order-2 order-lg-1">
                <span class="etiqueta-hero">🔥 Cocina con lo que ya tienes en casa</span>
                <h1 class="display-4 fw-bold mb-2">¿Qué cocinamos hoy?</h1>
                <p class="lead mb-4">Dinos qué ingredientes tienes y te sugerimos recetas bolivianas e internacionales para el desayuno, almuerzo o cena.</p>

                <form action="index.php?accion=confirmar" method="post" class="tarjeta-form" id="formIngredientes" data-validar novalidate>
                    <?= campoToken() ?>
                    <label for="ingredientes" class="form-label fw-semibold">Tus ingredientes</label>
                    <div class="input-group mb-2 has-validation">
                        <textarea id="ingredientes" name="ingredientes" class="form-control" rows="3" minlength="2" maxlength="400"
                                  placeholder="Ejemplo: papa, huevo, cebolla" required></textarea>
                        <button type="button" id="btnMicrofono" class="btn btn-outline-warning" title="Dictar ingredientes" aria-label="Dictar ingredientes por voz">🎤</button>
                        <div class="invalid-feedback">Escribe o dicta al menos un ingrediente.</div>
                    </div>
                    <div id="mensajeVoz" class="small text-secondary mb-3">
                        Separa los ingredientes con comas o con la palabra «y». También puedes usar el micrófono.
                    </div>
                    <button type="submit" class="btn btn-gustoff btn-lg">Continuar →</button>
                    <a href="index.php?accion=api_azar" class="btn btn-outline-gustoff btn-lg ms-1">Sorpréndeme</a>
                </form>
            </div>

            <div class="col-lg-5 order-1 order-lg-2 text-center">
                <img src="publico/img/portada.jpg" class="plato-portada" alt="Pollo al horno humeante con papas y verduras">
            </div>
        </div>
    </div>
</section>

<!-- CATEGORÍAS EN CÍRCULOS -->
<section class="py-3">
    <div class="container">
        <h2 class="h4 mb-2">Explora por categoría</h2>
        <div class="fila-categorias">
            <?php foreach ($categorias as $c): ?>
                <?php if ((int) $c["total"] === 0) { continue; } ?>
                <a class="cat-circulo" href="index.php?accion=catalogo&categoria=<?= (int) $c["id_categoria"] ?>">
                    <span class="cat-icono"><?= e($c["icono"] ?: "🍽") ?></span>
                    <?= e($c["nombre"]) ?>
                </a>
            <?php endforeach; ?>
            <a class="cat-circulo" href="index.php?accion=catalogo&rapidas=1">
                <span class="cat-icono">⚡</span>
                Fáciles y rápidas
            </a>
        </div>
    </div>
</section>

<!-- DESTACADAS -->
<main class="container py-4">
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h2 class="h4 mb-0">Recetas destacadas</h2>
        <a href="index.php?accion=catalogo" class="small text-warning">Ver todas →</a>
    </div>
    <div class="row g-3">
        <?php foreach ($destacadas as $receta): ?>
            <div class="col-sm-6 col-lg-4">
                <?php include __DIR__ . "/../plantilla/tarjeta_receta.php"; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
$scripts = ["publico/js/voz.js"];
require __DIR__ . "/../plantilla/pie.php";
