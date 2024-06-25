$(document).ready(function () {
    const token = localStorage.getItem("token");
    const baseUrl = window.apiUrl + "/api";
    const user = JSON.parse(localStorage.getItem("user"));
    const URLPDF = window.apiUrl + "/api/pdf/";

    $('#btn-agregar').click(function (e){
        e.preventDefault();
        $('#modalHorasExtra').modal('show');
    });

    $("#btnGuardarHoraExtra").click(function(e){
        e.preventDefault();
        
        let matricula = $("#ma_codigo").val();
        console.log(matricula);
        let data = {
            importe : $('#importe').val(),
            costo: $('#costo').val(),
            duracion: $("#duracion").val(),
            matricula: matricula 
        }

        $.ajax({
            type: "PUT",
            url: `${baseUrl}/manager_matricula/horario-extra/${matricula}`,
            data: data,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                if (response.status) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.message);
                   // http://127.0.0.1:8000/api/pdf//294/412
                    var url = `${URLPDF}comprobante-render/${response.data.cp_codigo}/${user.us_codigo}`;

                    $('#pdfIframe').attr('src', url);
                    $('#pdfModal').modal('show');
                    
                    $("#duracionCurso").empty();
                    $('#duracionCurso').append(`${response.duracion} Hrs.`);
                    $('#modalHorasExtra').modal('hide');
                    $('#formhorasExtra').trigger('reset');
                }
                else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(response.message);
                }
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

            },
            error: function (xhr) {
                console.error('Error al enviar datos:', xhr.responseJSON);

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.each(xhr.responseJSON.errors, function (key, value) {
                    var inputField = $('#' + key);
                    inputField.addClass('is-invalid');

                    var errorFeedback = $('<div class="invalid-feedback"></div>').text(value[0]); // Asume que quieres mostrar solo el primer mensaje de error
                    inputField.after(errorFeedback);
                });
            }
        });
    });
});