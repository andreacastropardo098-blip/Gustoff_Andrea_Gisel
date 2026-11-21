<?php
// Pantalla 2 - Confirmar ingredientes. Variable: $ingredientes
// (Los filtros y el tipo de plato se eligen en la pantalla de resultados.)
$titulo = "Confirmar ingredientes";
$pagina = "inicio";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<main class="container py-4">
    <h2 class="mb-1">Confirma tus ingredientes</h2>
    <p class="text-secondary">Quita los que no tengas o agrega otros. Después verás todo lo que puedes cocinar: sopas, segundos, ensaladas, desayunos y más.</p>

    <form action="index.php" method="get" id="formConfirmar" novalidate>
        <input type="hidden" name="accion" value="buscar">

        <div class="caja-oscura mb-4">
            <div id="listaIngredientes" class="mb-3">
                <?php foreach ($ingredientes as $ingrediente): ?>
                    <span class="badge rounded-pill chip-ingrediente">
                        <?= e($ingrediente) ?>
                        <input type="hidden" name="ingredientes[]" value="<?= e($ingrediente) ?>">
                        <button type="button" class="btn-quitar" aria-label="Quitar <?= e($ingrediente) ?>">&times;</button>
                    </span>
                <?php endforeach; ?>
            </div>
            <div id="errorIngredientes" class="text-danger small mb-2" hidden>Debes dejar al menos un ingrediente.</div>

            <div class="input-group" style="max-width: 420px;">
                <input type="text" id="nuevoIngrediente" class="form-control" maxlength="40" placeholder="Agregar otro ingrediente">
                <button type="button" id="btnAgregar" class="btn btn-outline-warning">Agregar</button>
            </div>
        </div>

        <a href="index.php" class="btn btn-outline-secondary">Volver</a>
        <button type="submit" class="btn btn-gustoff">Ver qué puedo cocinar →</button>
    </form>
</main>

<?php
$scripts = ["publico/js/ingredientes.js"];
require __DIR__ . "/../plantilla/pie.php";
