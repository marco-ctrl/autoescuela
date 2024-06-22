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
            url: BASEURL + "/docente_horario/reporte-asistencia",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: {
                fechaInicial: fechaInicial,
                fechaFinal: fechaFinal,
                usuario: user.us_codigo,
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
        let bgColor = resumen.asistencia == 1 ? "bg-success" : "bg-danger";
        let asistencia = resumen.asistencia == 1 ? "Asistencia" : "Falta";
        let html = `<tr>
                        <td>${resumen.hora_inicio}</td>
                        <td>${resumen.hora_final}</td>
                        <td>${resumen.numero}</td>
                        <td>${resumen.curso}</td>
                        <td>${resumen.fecha}</td>
                        <td>${resumen.estudiante}</td>
                        <td class="${bgColor} text-white">
                            <strong>${asistencia}</strong>
                        </td>
                        <td>${resumen.docente}</td>
                    </tr>`;
        return html;
    }
});
