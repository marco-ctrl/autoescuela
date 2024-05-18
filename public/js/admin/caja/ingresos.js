$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf/";

    var codigoingresos = 0;

    const token = localStorage.getItem("token");
    
    loadIngresos(1); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadIngresos(page) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/admin_caja/ingresos?page=" + page,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (response) {
                $("#overlay").hide();
                let data = response.data;
                $("#ingresosTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(data, function (index, ingresos) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#ingresosTable tbody").append(
                        cargarTablaIngresos(ingresos)
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

    // Manejar clics en los enlaces de paginación
    $(document).on("click", "#paginationContainer a", function (e) {
        e.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        loadIngresos(1);(page);
    });

    function cargarTablaIngresos(ingresos) {
        let disabled = ingresos.saldo == 0 ? "disabled" : "";

        let html = `<tr>
                        <td>${ingresos.fecha}</td>
                        <td>${ingresos.monto}</td>
                        <td>${ingresos.detalle}</td>
                        <td>${ingresos.usuario}</td>
                        <td>${ingresos.estudiante}</td>
                        <td>
                            <button class="btn btn-success pago" 
                                data-codigo="${ingresos.id}" 
                                data-ingresos="${ingresos.ingresos}"
                                title="pago cuota"
                                ${disabled}
                                >
                                <i class="fas fa-money-bill-wave"></i>
                            </button>
                        </td>
                    </tr>`;
        return html;
    }

    $(document).on("click", ".pago", function (e) {
        e.preventDefault();
        codigoingresos = $(this).data("codigo");
        let ingresos = $(this).data("ingresos");
        $("#modalPagoTitle").html("Pago de Cuota - ingresos: " + ingresos);
        $("#modalPago").modal("show");
    });

    $("#btnPago").click(function (e) {
        let data = {
            codigo: codigoingresos,
            pc_monto: $("#pc_monto").val(),
            pc_tipo: $("#pc_tipo").val(),
            documento: $("#documento").val(),
        };
        $.ajax({
            type: "POST",
            url: BASEURL + "/admin_pago",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
            },
            data: data,
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                $("#modalPago").modal("hide");

                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success("Pago realizado correctamente");
                    $("#formPago").trigger("reset");
                    loadIngresos(1);
                    var url = `${URLPDF}ingresos/${codigoingresos}/${user.us_codigo}/ticket`;

                    // Abrir la nueva pestaña
                    window.open(url, "_blank");
                } else {
                    alertify.set("notifier", "position", "top-right");
                    alertify.error(response.message);
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

    
});
