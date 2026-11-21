// Pantalla de confirmación: quitar y agregar ingredientes antes de buscar.
(function () {
    const lista = document.getElementById('listaIngredientes');
    const campo = document.getElementById('nuevoIngrediente');
    const botonAgregar = document.getElementById('btnAgregar');
    const formulario = document.getElementById('formConfirmar');
    const error = document.getElementById('errorIngredientes');

    lista.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-quitar')) {
            e.target.closest('.chip-ingrediente').remove();
            error.hidden = true;
        }
    });

    function agregar() {
        const texto = campo.value.trim();
        if (!texto) return;
        const chip = document.createElement('span');
        chip.className = 'badge rounded-pill chip-ingrediente';
        chip.append(texto + ' ');
        const oculto = document.createElement('input');
        oculto.type = 'hidden';
        oculto.name = 'ingredientes[]';
        oculto.value = texto;           // el servidor lo normaliza al buscar
        const quitar = document.createElement('button');
        quitar.type = 'button';
        quitar.className = 'btn-quitar';
        quitar.setAttribute('aria-label', 'Quitar ' + texto);
        quitar.innerHTML = '&times;';
        chip.append(oculto, quitar);
        lista.appendChild(chip);
        campo.value = '';
        campo.focus();
        error.hidden = true;
    }

    botonAgregar.addEventListener('click', agregar);
    campo.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); agregar(); }
    });

    // Validación: debe quedar al menos un ingrediente
    formulario.addEventListener('submit', function (e) {
        if (lista.querySelectorAll('input[name="ingredientes[]"]').length === 0) {
            e.preventDefault();
            error.hidden = false;
        }
    });
})();
