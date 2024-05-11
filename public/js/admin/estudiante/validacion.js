$(document).ready(function () {
    $("#es_tipodocumento").change(function () {
        var tipoDocumento = $(this).val();
        
        if (tipoDocumento == 2) {
            // CE
            $("#es_documento").val("E-");
        }
    });
});
