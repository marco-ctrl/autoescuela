$(document).ready(function () {
    const BASEURL = window.apiUrl + "/api";
    const token = localStorage.getItem("token");
    const user = JSON.parse(localStorage.getItem("user"));

    var costoTotal = 0;
    // Añadir detalle a la tabla
    $("#estudiante").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + "/manager_estudiante/autocomplete",
                dataType: "json",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
                },
                data: {
                    term: request.term, // envía el término de búsqueda al servidor
                },
                success: function (resp) {
                    response(resp.data); // Envía los datos al widget Autocomplete
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
            });
        },
        select: function (event, ui) {
            //$('#es_codigo').val(ui.item.id);
            $("#estudianteId").val(ui.item.id);
        },
    });

    $("#detalle").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + "/manager_producto/autocomplete",
                dataType: "json",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
                },
                data: {
                    term: request.term, // envía el término de búsqueda al servidor
                },
                success: function (resp) {
                    response(resp.data); // Envía los datos al widget Autocomplete
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
            });
        },
        select: function (event, ui) {
            //$('#es_codigo').val(ui.item.id);
            $("#detalleId").val(ui.item.id);
        },
    });

    function actualizarSumatoriaTotal() {
        let sumatoriaTotal = 0;
        $("#detallesTableBody tr").each(function () {
            let total = parseFloat($(this).find("td").eq(3).text());
            sumatoriaTotal += total;
        });
        $("#sumatoriaTotal").text(sumatoriaTotal.toFixed(2));
    }

    // Añadir detalle a la tabla
    $("#addDetalleBtn").click(function () {
        let detalle = $("#detalle").val();
        let cantidad = parseFloat($("#cantidad").val());
        let precio = parseFloat($("#precio").val());
        let total = cantidad * precio;

        if (detalle && !isNaN(cantidad) && !isNaN(precio)) {
            let row = `
                <tr>
                    <td>${detalle}</td>
                    <td>${cantidad}</td>
                    <td>${precio}</td>
                    <td>${total}</td>
                    <td><button type="button" class="btn btn-danger btn-sm deleteDetalleBtn">Eliminar</button></td>
                </tr>
            `;

            $("#detallesTableBody").append(row);

            // Limpiar los campos
            $("#detalle").val("");
            $("#cantidad").val("");
            $("#precio").val("");
            $("#total").val("");

            // Actualizar sumatoria total
            actualizarSumatoriaTotal();
        } else {
            alert("Por favor, complete todos los campos del detalle.");
        }
    });

    // Eliminar detalle de la tabla
    $(document).on("click", ".deleteDetalleBtn", function () {
        $(this).closest("tr").remove();
        actualizarSumatoriaTotal();
    });

    // Guardar datos y enviar al servidor
    $("#guardarBtn").click(function () {
        let estudiante = $("#estudianteId").val();
        let detalles = [];

        $("#detallesTableBody tr").each(function () {
            let detalle = $(this).find("td").eq(0).text();
            let cantidad = $(this).find("td").eq(1).text();
            let precio = $(this).find("td").eq(2).text();
            let total = $(this).find("td").eq(3).text();

            detalles.push({
                detalle: detalle,
                cantidad: cantidad,
                precio: precio,
                total: total,
            });
        });

        let data = {
            estudiante: estudiante,
            detalles: detalles,
        };

        $.ajax({
            type: "POST",
            url: BASEURL + "/manager_caja/ingresos",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: data,
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    $("#estudiante").val("");
                    $("#detallesTableBody").empty();
                    actualizarSumatoriaTotal();
                    loadIngresos(1, );
                    $("#modalIngresos").modal("hide");

                    url=`${BASEURL}/pdf/comprobante-render/${response.data.cp_codigo}/${user.us_codigo}`;
                    $("#pdfModalLabel").html("Comprobante de Ingreso");
                    $('#pdfIframe').attr('src', url);
                    $('#pdfModal').modal('show');
                }
            },
            error: function (xhr) {
                console.error("Error al enviar datos:", xhr.responseJSON);

                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $.each(xhr.responseJSON.errors, function (key, value) {
                    var inputField = $("#" + key);
                    inputField.addClass("is-invalid");

                    var errorFeedback = $(
                        '<div class="invalid-feedback"></div>'
                    ).text(value[0]); // Asume que quieres mostrar solo el primer mensaje de error
                    inputField.after(errorFeedback);
                });
            },
        });
    });

    $(".cancelar").click(function () {
        $("#estudiante").val("");
        $("#detallesTableBody").empty();
        actualizarSumatoriaTotal();
        $("#modalIngresos").modal("hide");
    });

    //loadIngresos(1); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadIngresos(page) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/manager_caja/ingresos?page=" + page + "&term=",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                cargandoDatos();
            },
            success: function (response) {
                $("#overlay").hide();
                let data = response.data;
                $("#ingresosTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(data, function (index, ingresos) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#ingresosTable tbody").append(
                        cargarTablaIngresos(ingresos, $("#buscarIngresos").val())
                    );
                });

                $("#paginationContainer").html(
                    generatePagination(response.pagination)
                ); // Imprimir la respuesta en la consola para depuración
            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
    }

    function generatePagination(response) {
        var paginationHtml = "";

        // Enlace "Previous"
        if (response.prev_page_url !== null) {
            paginationHtml +=
                '<li class="page-item"><a class="page-link" href="' +
                response.prev_page_url +
                '">Anterior</a></li>';
        } else {
            paginationHtml +=
                '<li class="page-item disabled"><span class="page-link">Anterior</span></li>';
        }

        // Enlaces de páginas
        $.each(response.links, function (index, link) {
            if (index !== 0 && index !== response.links.length - 1) {
                if (link.active) {
                    paginationHtml +=
                        '<li class="page-item active"><span class="page-link">' +
                        link.label +
                        "</span></li>";
                } else {
                    paginationHtml +=
                        '<li class="page-item"><a class="page-link" href="' +
                        link.url +
                        '">' +
                        link.label +
                        "</a></li>";
                }
            }
        });

        // Enlace "Next"
        if (response.next_page_url !== null) {
            paginationHtml +=
                '<li class="page-item"><a class="page-link" href="' +
                response.next_page_url +
                '">Siguiente</a></li>';
        } else {
            paginationHtml +=
                '<li class="page-item disabled"><span class="page-link">Siguiente</span></li>';
        }

        return paginationHtml;
    }

    function cargandoDatos() {
        $("#ingresosTable tbody").empty();
        $("#ingresosTable tbody").append(
            `<tr class="spinner-row">
                    <td colspan="8" align="center">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </div>
                    </td>
                </tr>`
        );
    }

    function cargarTablaIngresos(ingresos, term) {
        let html = `<tr>
                        <td>${ingresos.fecha}</td>
                        <td>${ingresos.documento}</td>
                        <td>${ingresos.monto}</td>
                        <td>${ingresos.detalle}</td>
                        <td>${ingresos.usuario}</td>
                        <td>${ingresos.estudiante}</td>
                        <td>
                        <a href="#" class="btn btn-success btn-sm pago"
                        data-toggle="modal" data-target="#pdfModal" 
                        data-pdf-url="${BASEURL}/pdf/comprobante-render/${ingresos.id}/${user.us_codigo}">
                        <i class="fas fa-ticket-alt"></i>
                       </a>
                        </td>
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
