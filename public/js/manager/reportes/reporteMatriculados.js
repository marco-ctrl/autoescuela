$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf";
    const token = localStorage.getItem("token");

    $("#btn-filtrar").click(function (e) {
        e.preventDefault();
        let fechaInicial = $("#fechaInicial").val();
        let fechaFinal = $("#fechaFinal").val();
        let usuario = $("#usuarios").val();

        ListarResumen(fechaInicial, fechaFinal, usuario);
    });

    $("#btn-pdf").click(function (e) {
        e.preventDefault();
        $("#usuario").val(user.us_codigo);
        $('#form').submit();
    });

    function ListarResumen(fechaInicial, fechaFinal, usuario) {
        $.ajax({
            type: "POST",
            url: BASEURL + "/filtrar_manager/reporte-matriculados",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: {
                fechaInicial: fechaInicial,
                fechaFinal: fechaFinal,
                usuario: usuario
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
                        <td>${resumen.fecha_inscripcion}</td>
                        <td>${resumen.nro_matricula}</td>
                        <td>${resumen.documento}</td>
                        <td>${resumen.nombres} ${resumen.apellidos}</td>
                        <td>${resumen.usuario}</td>
                        <td>${resumen.categoria}</td>
                        <td>${resumen.sede}</td>
                        <td>${resumen.curso}</td>
                    </tr>`;
        return html;
    }
});
