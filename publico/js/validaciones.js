// Validación de formularios en el navegador (JavaScript).
// Todo formulario con el atributo data-validar se revisa antes de enviarse.
// (El servidor PHP vuelve a validar siempre: esta capa solo mejora la experiencia.)
(function () {
    document.querySelectorAll('form[data-validar]').forEach(function (form) {

        // Campos que deben coincidir con otro (ej.: confirmar contraseña)
        function revisarIguales() {
            form.querySelectorAll('[data-igual-a]').forEach(function (campo) {
                const origen = document.getElementById(campo.dataset.igualA);
                campo.setCustomValidity(origen && campo.value !== origen.value ? 'No coinciden' : '');
            });
        }
        form.addEventListener('input', revisarIguales);

        form.addEventListener('submit', function (e) {
            revisarIguales();

            // Un texto formado solo por espacios no cuenta
            form.querySelectorAll('input[required][type="text"], textarea[required]').forEach(function (c) {
                if (c.value.trim() === '') { c.value = ''; }
            });

            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                const primero = form.querySelector(':invalid');
                if (primero) { primero.focus(); }
            }
            form.classList.add('was-validated');
        });
    });
})();
