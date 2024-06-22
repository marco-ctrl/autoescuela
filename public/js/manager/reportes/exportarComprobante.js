$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const token = localStorage.getItem("token");

    $("#usuario").val(user.us_codigo);

    $("#btn-filtrar").click(function (e) {
        e.preventDefault();
        ListarResumen($("#fechaInicial").val(), $("#fechaFinal").val());
    });

    $("#btn-pdf").click(function (e) {
        e.preventDefault();
        $("#usuario").val(user.us_codigo);
        $("#form").submit();
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
                    let num = 0;
                    $("#ingresosTable tbody").empty();
                    $.each(response.ingreso, function (index, ingreso) {
                        num++;
                        $("#ingresosTable tbody").append(
                            cargarTablaIngresos(ingreso, num)
                        );
                    });
                } else {
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

    function cargarTablaIngresos(ingresos, num) {
        let html = `<tr>
                        <td>${num}</td>
                        <td>${ingresos.fecha}</td>
                        <td>${ingresos.documento}</td>
                        <td>${ingresos.detalle}</td>
                        <td>${ingresos.usuario}</td>
                        <td>${ingresos.estudiante}</td>
                        <td>${ingresos.monto}</td>
                        <td>
                        <a href="#" class="btn btn-primary btn-sm" title="Ver Comprobante"
                        data-toggle="modal" data-target="#pdfModal" 
                        data-pdf-url="${BASEURL}/pdf/comprobante/${ingresos.id}/${user.us_codigo}">
                        <i class="fas fa-print"></i>
                       </a>
                        </td>
                    </tr>`;
        return html;
    }
   
});
