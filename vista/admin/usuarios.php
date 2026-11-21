<?php
// Gestión de usuarios. Variables: $lista, $filtros
$titulo = "Usuarios";
$pagina = "admin";
$seccion = "usuarios";
require __DIR__ . "/../plantilla/encabezado.php";
?>

<main class="container py-4">
    <h2 class="mb-3">Usuarios</h2>
    <?php require __DIR__ . "/menu.php"; ?>

    <form action="index.php" method="get" class="caja-oscura mb-3" novalidate>
        <input type="hidden" name="accion" value="admin_usuarios">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label class="form-label small" for="uQ">Nombre o correo</label>
                <input type="search" id="uQ" name="q" class="form-control" maxlength="60" value="<?= e($filtros["q"]) ?>">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label small" for="uRol">Rol</label>
                <select id="uRol" name="rol" class="form-select">
                    <option value="">Todos</option>
                    <option value="administrador" <?= $filtros["rol"] === "administrador" ? "selected" : "" ?>>Administrador</option>
                    <option value="usuario" <?= $filtros["rol"] === "usuario" ? "selected" : "" ?>>Usuario</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small" for="uEstado">Estado</label>
                <select id="uEstado" name="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" <?= $filtros["estado"] === "1" ? "selected" : "" ?>>Activos</option>
                    <option value="0" <?= $filtros["estado"] === "0" ? "selected" : "" ?>>Desactivados</option>
                </select>
            </div>
            <div class="col-12 col-md-2 d-grid"><button class="btn btn-gustoff" type="submit">Filtrar</button></div>
        </div>
    </form>

    <div class="table-responsive caja-oscura p-2">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
                <?php if (empty($lista)): ?>
                    <tr><td colspan="5" class="text-center text-secondary py-4">No hay usuarios con esos filtros.</td></tr>
                <?php endif; ?>
                <?php foreach ($lista as $u): ?>
                    <?php $soyYo = (int) $u["id_usuario"] === Sesion::id(); ?>
                    <tr>
                        <td><?= e($u["nombre"]) ?> <?= $soyYo ? '<span class="badge text-bg-info">Tú</span>' : "" ?></td>
                        <td><?= e($u["correo"]) ?></td>
                        <td><span class="badge <?= $u["rol"] === "administrador" ? "text-bg-warning" : "text-bg-secondary" ?>"><?= $u["rol"] === "administrador" ? "Administrador" : "Usuario" ?></span></td>
                        <td><?= $u["activo"] ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-secondary">Desactivado</span>' ?></td>
                        <td class="text-end text-nowrap">
                            <?php if (!$soyYo): ?>
                                <form action="index.php?accion=admin_usuario_rol" method="post" class="d-inline">
                                    <?= campoToken() ?>
                                    <input type="hidden" name="id_usuario" value="<?= (int) $u["id_usuario"] ?>">
                                    <input type="hidden" name="rol" value="<?= $u["rol"] === "administrador" ? "usuario" : "administrador" ?>">
                                    <button class="btn btn-sm btn-outline-light" type="submit"><?= $u["rol"] === "administrador" ? "Hacer usuario" : "Hacer administrador" ?></button>
                                </form>
                                <form action="index.php?accion=admin_usuario_estado" method="post" class="d-inline">
                                    <?= campoToken() ?>
                                    <input type="hidden" name="id_usuario" value="<?= (int) $u["id_usuario"] ?>">
                                    <button class="btn btn-sm btn-outline-warning" type="submit"><?= $u["activo"] ? "Desactivar" : "Activar" ?></button>
                                </form>
                            <?php else: ?>
                                <span class="text-secondary small">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require __DIR__ . "/../plantilla/pie.php";
