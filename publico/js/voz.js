// Ingreso de ingredientes por voz (Web Speech API). Siempre queda la opción de escribir.
(function () {
    const boton = document.getElementById('btnMicrofono');
    const campo = document.getElementById('ingredientes');
    const mensaje = document.getElementById('mensajeVoz');
    if (!boton || !campo) { return; }
    const Reconocimiento = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!Reconocimiento) {
        boton.disabled = true;
        mensaje.textContent = 'Tu navegador no permite dictar por voz (prueba con Chrome). Escribe los ingredientes separados por comas.';
        return;
    }

    const reconocedor = new Reconocimiento();
    reconocedor.lang = 'es-BO';
    reconocedor.interimResults = false;

    boton.addEventListener('click', function () {
        mensaje.textContent = 'Escuchando... di tus ingredientes (ejemplo: papa, huevo y cebolla).';
        try { reconocedor.start(); } catch (e) { /* ya estaba escuchando */ }
    });

    reconocedor.onresult = function (evento) {
        const texto = evento.results[0][0].transcript;
        campo.value = campo.value.trim() ? campo.value.trim() + ', ' + texto : texto;
        mensaje.textContent = 'Revisa el texto reconocido y corrígelo si hace falta.';
    };

    reconocedor.onerror = function () {
        mensaje.textContent = 'No se pudo reconocer la voz; puedes escribir los ingredientes.';
    };
})();
