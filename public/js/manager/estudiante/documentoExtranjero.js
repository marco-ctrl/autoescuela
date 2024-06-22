document.getElementById('es_tipodocumento').addEventListener('change', function() {
    var tipoDocumento = this.value;
    var documentoInput = document.getElementById('es_documento');
    if (tipoDocumento === '2') { // CE seleccionado
        if (!documentoInput.value.startsWith('E-')) {
            documentoInput.value = 'E-';
        }
    } else {
        if (documentoInput.value.startsWith('E-')) {
            documentoInput.value = documentoInput.value.substring(2); // Remover 'E-' si se cambia a otro tipo
        }
    }
});