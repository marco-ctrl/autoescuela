$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf/";

    var codigoegresos = 0;

    const token = localStorage.getItem("token");
    let timeout = null;

    $("#buscarEgresos").on("keyup", function () {
        if (timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            let term = $("#buscarEgresos").val();
            loadEgresos(1, term);
        }, 2000);
    });


    $("#btnBuscarEgresos").click(function () {
        let term = $("#buscarEgresos").val();
        loadEgresos(1, term);
    });
    
    loadEgresos(1, ''); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadEgresos(page, term) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/admin_caja/egresos?page=" + page + "&term=" + term,
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
                $("#egresosTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(data, function (index, egresos) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#egresosTable tbody").append(
                        cargarTablaEgresos(egresos)
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
        loadEgresos(page, $("#buscarEgresos").val());
    });

    function cargarTablaEgresos(egresos) {
        let disabled = egresos.saldo == 0 ? "disabled" : "";

        let html = `<tr>
                        <td>${egresos.fecha}</td>
                        <td>${egresos.monto}</td>
                        <td>${egresos.detalle}</td>
                        <td>${egresos.usuario}</td>
                        <td>${egresos.emitido}</td>
                        <td>
                        <a href="#" class="btn btn-success btn-sm pago"
                        data-toggle="modal" data-target="#pdfModal"
                        data-title="Egreso Ticket" 
                        data-pdf-url="${BASEURL}/pdf/comprobante-egreso-render/${egresos.id}/${user.us_codigo}">
                        <i class="fas fa-ticket-alt"></i>
                       </a>
                        </td>
                        <td>
                        <a href="#" class="btn btn-primary btn-sm" title="Ver Comprobante"
                        data-toggle="modal" data-target="#pdfModal"
                        data-title="Egreso" 
                        data-pdf-url="${BASEURL}/pdf/comprobante-egreso/${egresos.id}/${user.us_codigo}">
                        <i class="fas fa-print"></i>
                       </a>
                        </td>
                    </tr>`;
        return html;
    }

    function cargandoDatos() {
        $("#egresosTable tbody").empty();
        $("#egresosTable tbody").append(
            `<tr class="spinner-row">
                    <td colspan="7" align="center">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </div>
                    </td>
                </tr>`
        );
    }

});
