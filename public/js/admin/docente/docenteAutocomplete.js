$(document).ready(function() {
    $('#docente').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '/admin/buscar-docente',
                dataType: "json",
                data: {
                    term: request.term // envía el término de búsqueda al servidor
                },
                success: function(data) {
                    console.log(data); // Aquí puedes ver la respuesta completa del servidor
                    response(data); // Envía los datos al widget Autocomplete
                }
            });
        },
        select: function(event, ui) {
            $('#do_codigo').val(ui.item.id);
            console.log(ui.item.id);
        }
    });
});