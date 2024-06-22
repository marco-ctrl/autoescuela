$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf";
    const token = localStorage.getItem("token");

    $("#btn-filtrar").click(function (e) {
        e.preventDefault();
        ListarResumen($("#fechaInicial").val(), $('#fechaFinal').val());
    });

    $("#btn-pdf").click(function (e) {
        e.preventDefault();
        $("#usuario").val(user.us_codigo);
        $('#form').submit();
    });

    function ListarResumen(fechaInicial, fechaFinal) {
        $.ajax({
            type: "POST",
            url: BASEURL + "/filtrar_manager/cronograma-resumen",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: {
                fechaInicial: fechaInicial,
                fechaFinal: fechaFinal,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                if (response.status) {
                    console.log(response.data);
                    $("#resumenTable tbody").empty();
                    $.each(response.data, function (index, resumen) {
                        $("#resumenTable tbody").append(
                            cargarTablaResumen(resumen)
                        );
                    });
                }
                else{
                    /*estudiantes = [];
                    $("#datos").val(estudiantes);
                    $("#generalTable tbody").empty();
                    $("#generalTable tbody").append(
                        `<tr>
                            <td colspan="11">No hay datos disponibles</td>
                        </tr>`
                    );*/
                }
            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
    }

    function cargarTablaResumen(resumen) {
        let html = `<tr>
                        <td>${resumen.asistencia}</td>
                        <td>${resumen.hora_inicio}</td>
                        <td>${resumen.hora_fin}</td>
                        <td>${resumen.clase}</td>
                        <td>${resumen.curso}</td>
                        <td>${resumen.dia}</td>
                        <td>${resumen.estudiante}</td>
                        <td>${resumen.instructor}</td>
                    </tr>`;
        return html;
    }
});
