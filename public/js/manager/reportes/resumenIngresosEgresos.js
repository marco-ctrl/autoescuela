$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf";
    const token = localStorage.getItem("token");

    $("#usuario").val(user.us_codigo);
    
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
            url: BASEURL + "/filtrar_manager/resumen-ingresos-egresos",
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
                    let resumen = response.resumen;
                    $("#resumenTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                    $("#resumenTable tbody").append(
                        cargarTablaResumen(resumen)
                    );

                    let num = 0;
                    $("#ingresosTable tbody").empty();
                    $.each(response.ingreso, function (index, ingreso) {
                        num++;
                        $("#ingresosTable tbody").append(
                            cargarTablaIngresos(ingreso, num)
                        );
                    });

                    $("#ingresosTable tfoot").empty();
                    $("#ingresosTable tfoot").append(
                        `<tr>
                            <th colspan="6">Total Bs.:</th>
                            <td>${resumen.ingreso}</td>
                        </tr>`
                    );

                    num = 0;
                    $("#egresosTable tbody").empty();
                    $.each(response.egreso, function (index, egresos) {
                        num ++;
                        $("#egresosTable tbody").append(
                            cargarTablaEgresos(egresos, num)
                        );
                    });

                    $("#egresosTable tfoot").empty();
                    $("#egresosTable tfoot").append(
                        `<tr>
                            <th colspan="5">Total Bs.:</th>
                            <td>${resumen.egreso}</td>
                        </tr>`
                    );
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
                        <td>${resumen.usuario}</td>
                        <td>${resumen.ingreso}</td>
                        <td>${resumen.egreso}</td>
                        <td>${resumen.total}</td>
                    </tr>`;
        return html;
    }

    function cargarTablaIngresos(ingresos, num) {
        let html = `<tr>
                        <td>${num}</td>
                        <td>${ingresos.fecha}</td>
                        <td>${ingresos.documento}</td>
                        <td>${ingresos.detalle}</td>
                        <td>${ingresos.usuario}</td>
                        <td>${ingresos.estudiante}</td>
                        <td>${ingresos.monto}</td>
                    </tr>`;
        return html;
    }

    function cargarTablaEgresos(egresos, num) {
        let html = `<tr>
                        <td>${num}</td>
                        <td>${egresos.fecha}</td>
                        <td>${egresos.detalle}</td>
                        <td>${egresos.usuario}</td>
                        <td>${egresos.emitido}</td>
                        <td>${egresos.monto}</td>
                    </tr>`;
        return html;
    }
});
