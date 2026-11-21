<?php
// Pie común: footer y scripts. Variable opcional: $scripts (lista de archivos JS de publico/js/)
$scripts = $scripts ?? [];
?>
<footer class="text-center small py-4 pie-gustoff">
    Recetas Gustoff · Proyecto final de Programación II · Sacaba, Cochabamba
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="publico/js/validaciones.js"></script>
<?php foreach ($scripts as $js): ?>
<script src="<?= e($js) ?>"></script>
<?php endforeach; ?>
<script>
    // Los avisos desaparecen solos a los 5 segundos
    (function () {
        const aviso = document.getElementById("aviso");
        if (aviso) { setTimeout(function () { aviso.classList.remove("show"); setTimeout(function () { aviso.remove(); }, 300); }, 5000); }
    })();
</script>
</body>
</html>
