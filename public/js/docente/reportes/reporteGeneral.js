$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf";
    const token = localStorage.getItem("token");

    $("#usuario").val(user.us_codigo);
    var estudiantes = [];

    $("#docente").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + "/admin_docente/autocomplete",
                dataType: "json",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    term: request.term, // envía el término de búsqueda al servidor
                },
                success: function (resp) {
                    response(resp.data); // Envía los datos al widget Autocomplete
                },
                error: function (xhr, status, error) {
                    console.error(
                        "Error al obtener los docentes:",
                        xhr.responseJSON
                    );
                }
            });
        },
        select: function (event, ui) {
            $("#do_codigo").val(ui.item.id);
        },
    });

    $("#btn-filtrar").click(function (e) {
        e.preventDefault();
        ListarEstudiantes($("#fecha").val(), user.docente.do_codigo);
    });

    function ListarEstudiantes(fecha, do_codigo) {
        console.log(do_codigo, fecha);
        $.ajax({
            type: "POST",
            url: BASEURL + "/filtrar/reporte-general",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: {
                fecha: fecha,
                codigo: do_codigo,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                if (response.status) {
                    estudiantes = response.data;
                    $("#datos").val(JSON.stringify(response.data));
                    $("#titulo-table").append(response.data[0].titulo);
                    $("#generalTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                    $.each(response.data, function (index, matricula) {
                        $("#generalTable tbody").append(
                            cargarTablaMatricula(matricula)
                        );
                    });
                }
                else{
                    estudiantes = [];
                    $("#datos").val(estudiantes);
                    $("#generalTable tbody").empty();
                    $("#generalTable tbody").append(
                        `<tr>
                            <td colspan="11">No hay datos disponibles</td>
                        </tr>`
                    );
                }
            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
    }

    function cargarTablaMatricula(matricula) {
        let observacion =
            matricula.observacion == null ? "" : matricula.observacion;

        let html = `<tr>
                        <td>${matricula.hora}</td>
                        <td>${matricula.matricula}</td>
                        <td class="${matricula.textColor}">${matricula.saldo}</td>                       
                        <td>${matricula.sede}</td>
                        <td>${matricula.ci}</td>
                        <td>${matricula.estudiante}</td>
                        <td>${matricula.categoria}</td>
                        <td>${matricula.curso}</td>
                        <td>${matricula.numero}</td>
                        <td>${observacion}</td>
                        <td>${matricula.firma}</td>
                    </tr>`;
        return html;
    }
});
