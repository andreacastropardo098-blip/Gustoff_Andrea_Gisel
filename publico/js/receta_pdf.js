// Descarga la receta en PDF usando la librería jsPDF (los datos vienen en la constante RECETA_PDF).
(function () {
    const boton = document.getElementById('btnPdfReceta');
    if (!boton || typeof RECETA_PDF === 'undefined') { return; }

    boton.addEventListener('click', function () {
        if (!window.jspdf) { alert('No se pudo cargar la librería de PDF. Revisa tu conexión a internet.'); return; }
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ unit: 'mm', format: 'a4' });
        const margen = 18, ancho = 210 - margen * 2;
        let y = 20;

        function escribir(texto, tam, estilo, espacio) {
            doc.setFont('helvetica', estilo || 'normal');
            doc.setFontSize(tam);
            doc.splitTextToSize(texto, ancho).forEach(function (linea) {
                if (y > 277) { doc.addPage(); y = 20; }
                doc.text(linea, margen, y);
                y += tam * 0.45;
            });
            y += espacio || 2;
        }

        doc.setFillColor(232, 89, 12);
        doc.rect(0, 0, 210, 12, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(10);
        doc.text('Recetas Gustoff · Sacaba, Cochabamba', margen, 8);
        doc.setTextColor(30, 30, 30);

        escribir(RECETA_PDF.nombre, 20, 'bold', 3);
        if (RECETA_PDF.descripcion) { escribir(RECETA_PDF.descripcion, 11, 'italic', 3); }
        escribir('Categoría: ' + (RECETA_PDF.categoria || 'Sin categoría') + '   |   Tiempo: ' + RECETA_PDF.tiempo +
                 ' min   |   Porciones: ' + RECETA_PDF.porciones + '   |   Dificultad: ' + RECETA_PDF.dificultad, 10, 'normal', 6);

        escribir('Ingredientes', 14, 'bold', 2);
        RECETA_PDF.ingredientes.forEach(function (i) { escribir('•  ' + i, 11, 'normal', 1); });

        y += 4;
        escribir('Preparación', 14, 'bold', 2);
        RECETA_PDF.pasos.forEach(function (p, n) { escribir((n + 1) + '.  ' + p, 11, 'normal', 2); });

        doc.save(RECETA_PDF.nombre.replace(/[^\w\-]+/g, '_') + '.pdf');
    });
})();
