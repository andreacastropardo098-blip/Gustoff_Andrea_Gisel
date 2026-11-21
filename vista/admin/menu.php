<?php
// Submenú del panel de administración. Variable: $seccion
$seccion = $seccion ?? "";
$items = [
    "panel"      => ["admin_panel", "📊 Resumen"],
    "recetas"    => ["admin_recetas", "🍽 Recetas"],
    "categorias" => ["admin_categorias", "🏷 Categorías"],
    "usuarios"   => ["admin_usuarios", "👥 Usuarios"]
];
?>
<ul class="nav nav-pills menu-admin mb-4 flex-wrap gap-1">
    <?php foreach ($items as $clave => [$accion, $texto]): ?>
        <li class="nav-item"><a class="nav-link <?= $seccion === $clave ? "active" : "" ?>" href="index.php?accion=<?= $accion ?>"><?= $texto ?></a></li>
    <?php endforeach; ?>
</ul>
