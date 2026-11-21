<?php
// Encabezado común: <head>, barra de navegación y mensajes.
// Variables esperadas: $titulo (texto), $pagina (inicio|catalogo|admin|login|registro)
$titulo = $titulo ?? "Recetas Gustoff";
$pagina = $pagina ?? "";
$usuarioActual = Sesion::usuario();
$flash = Sesion::tomarFlash();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?> - Recetas Gustoff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="publico/css/estilos.css">
</head>
<body class="fondo-sanji">

<nav class="navbar navbar-expand-lg barra-gustoff sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🍲 Recetas Gustoff</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
                aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= $pagina === "inicio" ? "active" : "" ?>" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link <?= $pagina === "catalogo" ? "active" : "" ?>" href="index.php?accion=catalogo">Recetas</a></li>
                <?php if (Sesion::esAdmin()): ?>
                    <li class="nav-item"><a class="nav-link <?= $pagina === "admin" ? "active" : "" ?>" href="index.php?accion=admin_panel">⚙ Panel de administración</a></li>
                <?php endif; ?>
            </ul>

            <form class="d-flex me-lg-3 mb-2 mb-lg-0" action="index.php" method="get" role="search">
                <input type="hidden" name="accion" value="catalogo">
                <input class="form-control form-control-sm me-2" type="search" name="q" maxlength="60" placeholder="Buscar receta o ingrediente" aria-label="Buscar">
                <button class="btn btn-sm btn-light" type="submit">Buscar</button>
            </form>

            <div class="d-flex align-items-center gap-2">
                <?php if ($usuarioActual): ?>
                    <span class="small text-white-50">
                        Hola, <strong class="text-white"><?= e($usuarioActual["nombre"]) ?></strong>
                        <span class="badge text-bg-light"><?= $usuarioActual["rol"] === "administrador" ? "Administrador" : "Usuario" ?></span>
                    </span>
                    <form action="index.php?accion=salir" method="post" class="m-0">
                        <?= campoToken() ?>
                        <button type="submit" class="btn btn-sm btn-outline-light">Cerrar sesión</button>
                    </form>
                <?php else: ?>
                    <a href="index.php?accion=login" class="btn btn-sm btn-outline-light">Ingresar</a>
                    <a href="index.php?accion=registro" class="btn btn-sm btn-light">Crear cuenta</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if ($flash): ?>
    <div class="container mt-3">
        <div class="alert alert-<?= e($flash[0]) ?> alert-dismissible fade show mb-0" role="alert" id="aviso">
            <?= e($flash[1]) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    </div>
<?php endif; ?>
