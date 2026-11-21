<?php
// Crear cuenta de usuario. Variables: $errores, $nombre, $correo
$titulo = "Crear cuenta";
$pagina = "registro";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <form action="index.php?accion=registro" method="post" class="tarjeta-form" data-validar novalidate>
                <?= campoToken() ?>
                <h1 class="h3 mb-3">Crear cuenta</h1>

                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errores as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" minlength="2" maxlength="100" required
                           value="<?= e($nombre) ?>" autocomplete="name">
                    <div class="invalid-feedback">El nombre debe tener entre 2 y 100 caracteres.</div>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" maxlength="120" required
                           value="<?= e($correo) ?>" autocomplete="email">
                    <div class="invalid-feedback">Escribe un correo válido.</div>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="clave" name="clave" minlength="6" maxlength="72" required
                           pattern="(?=.*[A-Za-z])(?=.*\d).{6,72}" autocomplete="new-password">
                    <div class="form-text">Mínimo 6 caracteres, con letras y números.</div>
                    <div class="invalid-feedback">Usa al menos 6 caracteres, con letras y números.</div>
                </div>
                <div class="mb-3">
                    <label for="confirmar" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="confirmar" name="confirmar" required autocomplete="new-password" data-igual-a="clave">
                    <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                </div>
                <button type="submit" class="btn btn-gustoff w-100">Crear cuenta</button>
                <p class="small text-secondary mt-3 mb-0">¿Ya tienes cuenta? <a href="index.php?accion=login" class="text-warning">Inicia sesión</a></p>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
