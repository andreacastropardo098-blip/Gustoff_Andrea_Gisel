<?php
// Iniciar sesión. Variables: $errores, $correo
$titulo = "Iniciar sesión";
$pagina = "login";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <form action="index.php?accion=login" method="post" class="tarjeta-form" data-validar novalidate>
                <?= campoToken() ?>
                <h1 class="h3 mb-3">Iniciar sesión</h1>

                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errores as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" maxlength="120" required
                           value="<?= e($correo) ?>" autocomplete="email">
                    <div class="invalid-feedback">Escribe un correo válido.</div>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="clave" name="clave" required autocomplete="current-password">
                    <div class="invalid-feedback">Escribe tu contraseña.</div>
                </div>
                <button type="submit" class="btn btn-gustoff w-100">Ingresar</button>
                <p class="small text-secondary mt-3 mb-0">¿No tienes cuenta? <a href="index.php?accion=registro" class="text-warning">Regístrate aquí</a></p>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
