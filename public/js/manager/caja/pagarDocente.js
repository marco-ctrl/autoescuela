$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf/";

    var codigoDocente = 0;

    const token = localStorage.getItem("token");

    $("#btnBuscarDocente").click(function () {
        let term = $("#buscarDocente").val();
        loadDocentes(1, term);
    });

    loadDocentes(1, ''); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadDocentes(page, term) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/manager_docente/pago-docente?page=" + page + "&term=" + term,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (response) {
                $("#overlay").hide();
                let data = response.data.filter(function(item){
                    return item.horas_no_pagadas > 0;
                });
                $("#docenteTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(data, function (index, docente) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#docenteTable tbody").append(
                        cargarTablaDocente(docente)
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
        loadDocentes(page, $('#buscarDocente').val());
    });

    function cargarTablaDocente(docente) {
        
        let html = `<tr>
                        <td><img src="${docente.foto}" class="img-perfil-tabla"></td>
                        <td>${docente.documento}</td>
                        <td>${docente.docente}</td>
                        <td>${docente.pago_hora}</td>
                        <td>${docente.horas_pagadas}</td>
                        <td>${docente.horas_no_pagadas}</td>
                        <td>
                            <button class="btn btn-success pago" 
                                data-codigo="${docente.id}"
                                data-docente="${docente.docente}"
                                data-falta="${docente.horas_no_pagadas}"
                                data-sueldo="${docente.pago_hora}"
                                title="pago docente">
                                <i class="fas fa-money-bill-wave"></i>
                            </button>
                        </td>
                    </tr>`;
        return html;
    }

    $(document).on("click", ".pago", function (e) {
        e.preventDefault();
        codigoDocente = $(this).data("codigo");
        let docente = $(this).data("docente");
        
        $("#modalPagoTitle").html("Pagar Hora - Docente: " + docente);
        $("#faltaPagar").html("TOTAL HORAS FALTA<br><strong>PAGAR: " 
            + $(this).data("falta") + " HORAS</strong>");
        $("#sueldoHora").html(`SUELDO POR HORA: ${$(this).data("sueldo")}`)
        $("#horas").attr('max', $(this).data("falta"));
        $("#modalPago").modal("show");
    });

    $("#btnPagarDocente").click(function (e) {
        let data = {
            codigo: codigoDocente,
            horas_pago: $('#horas').val(),
        };
        $.ajax({
            type: "POST",
            url: BASEURL + "/manager_docente/pago-docente",
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
                    loadDocentes(1, $("#buscarDocente").val());
                    var url = `${URLPDF}pago-docente/${response.data.pd_codigo}`;

                    // Abrir la nueva pestaña
                    //window.open(url, "_blank");
                    $('#pdfIframe').attr('src', url);
                    $('#pdfModal').modal('show');
                    //window.open(url, "_blank");
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

    listarComprobante();

    function listarComprobante() {
        $.ajax({
            url: BASEURL + "/manager_comprobante",
            type: "get",
            dataType: "json",
            success: function (response) {
                var select = $("#documento");

                if (response.status) {
                    $.each(response.data, function (i, item) {
                        select.append(
                            $("<option></option>")
                                .attr("value", item.cb_descripcion)
                                .text(item.cb_descripcion)
                        );
                    });
                } else {
                    console.log(
                        "La respuesta del servidor no tiene un estado exitoso."
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(
                    "Error al cargar los datos: ",
                    textStatus,
                    errorThrown
                );
            },
        });
    }
});
