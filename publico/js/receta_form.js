// Formulario de recetas (administrador): filas dinámicas de ingredientes y pasos + validaciones.
(function () {
    const form = document.getElementById('formReceta');
    const contIng = document.getElementById('contenedorIngredientes');
    const contPasos = document.getElementById('contenedorPasos');

    function filaIngrediente() {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 fila-ingrediente';
        div.innerHTML =
            '<div class="col-12 col-md-4"><input type="text" class="form-control" name="ing_nombre[]" list="listaIngredientesSugeridos" maxlength="80" placeholder="Ingrediente"></div>' +
            '<div class="col-4 col-md-2"><input type="number" step="0.01" min="0" max="99999" class="form-control" name="ing_cantidad[]" placeholder="Cantidad"></div>' +
            '<div class="col-8 col-md-3"><input type="text" class="form-control" name="ing_unidad[]" maxlength="30" placeholder="Unidad (g, tazas...)"></div>' +
            '<div class="col-8 col-md-2"><select class="form-select" name="ing_opcional[]"><option value="0">Necesario</option><option value="1">Opcional</option></select></div>' +
            '<div class="col-4 col-md-1 d-grid"><button type="button" class="btn btn-outline-danger btn-quitar-fila" aria-label="Quitar ingrediente">✕</button></div>';
        return div;
    }

    function filaPaso() {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 fila-paso';
        div.innerHTML =
            '<div class="col-auto pt-2"><span class="badge text-bg-warning numero-paso">1</span></div>' +
            '<div class="col"><textarea class="form-control" name="pasos[]" rows="2" maxlength="500" placeholder="Describe este paso"></textarea></div>' +
            '<div class="col-auto"><button type="button" class="btn btn-outline-danger btn-quitar-fila" aria-label="Quitar paso">✕</button></div>';
        return div;
    }

    function renumerar() {
        contPasos.querySelectorAll('.numero-paso').forEach(function (n, i) { n.textContent = i + 1; });
    }

    document.getElementById('btnAgregarIngrediente').addEventListener('click', function () {
        const fila = filaIngrediente();
        contIng.appendChild(fila);
        fila.querySelector('input').focus();
    });
    document.getElementById('btnAgregarPaso').addEventListener('click', function () {
        const fila = filaPaso();
        contPasos.appendChild(fila);
        renumerar();
        fila.querySelector('textarea').focus();
    });

    // Quitar filas (siempre debe quedar al menos una)
    form.addEventListener('click', function (e) {
        const boton = e.target.closest('.btn-quitar-fila');
        if (!boton) return;
        const fila = boton.closest('.fila-ingrediente, .fila-paso');
        const contenedor = fila.parentElement;
        if (contenedor.children.length > 1) {
            fila.remove();
            renumerar();
        } else {
            fila.querySelectorAll('input, textarea').forEach(function (c) { c.value = ''; });
        }
    });

    // Validaciones propias antes de enviar
    form.addEventListener('submit', function (e) {
        let ok = true;

        const nombres = Array.from(contIng.querySelectorAll('input[name="ing_nombre[]"]'))
            .filter(function (c) { return c.value.trim() !== ''; });
        const errIng = document.getElementById('errorIngredientes');
        errIng.hidden = nombres.length > 0;
        if (nombres.length === 0) ok = false;

        const pasos = Array.from(contPasos.querySelectorAll('textarea'))
            .filter(function (c) { return c.value.trim().length >= 5; });
        const errPasos = document.getElementById('errorPasos');
        errPasos.hidden = pasos.length > 0;
        if (pasos.length === 0) ok = false;

        // Enlace de imagen: si se escribe, debe ser http(s)
        const enlace = document.getElementById('imagen_enlace');
        if (enlace.value.trim() !== '' && !/^https?:\/\//i.test(enlace.value.trim())) {
            enlace.setCustomValidity('Enlace no válido');
        } else {
            enlace.setCustomValidity('');
        }

        // Tamaño y tipo de la imagen subida
        const archivo = document.getElementById('imagen').files[0];
        if (archivo && (archivo.size > 2 * 1024 * 1024 || !/^image\/(jpeg|png|webp)$/.test(archivo.type))) {
            alert('La imagen debe ser JPG, PNG o WEBP y pesar máximo 2 MB.');
            ok = false;
        }

        if (!ok) { e.preventDefault(); e.stopImmediatePropagation(); }
    }, true);
})();
