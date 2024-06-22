$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf/";

    var codigoProgramacion = 0;

    const token = localStorage.getItem("token");

    loadProgramacion(1, ''); // Cargar la primera página al cargar la página

    let timeout = null;

    $("#buscarEstudiante").on("keyup", function () {
        if (timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            let term = $("#buscarEstudiante").val();
            loadProgramacion(1, term);
        }, 2000);
    });

    $("#btnBuscarEstudiante").click(function () {
        let term = $("#buscarEstudiante").val();
        loadProgramacion(1, term);
    });

    // Función para cargar los datos de las citas
    function loadProgramacion(page, term) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/manager_certificado_antecedentes?page=" + page + "&term=" + term,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                cargandoDatos();
            },
            success: function (response) {
                let data = response.data
                $("#matriculaTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(data, function (index, matricula) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#matriculaTable tbody").append(
                        cargarTablaMatricula(matricula)
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
        loadProgramacion(page, $("#buscarEstudiante").val());
    });

    function cargarTablaMatricula(matricula) {
        let disabled = matricula.saldo <= 0 ? "disabled" : "";
        let colorSaldo = matricula.saldo <= 0 ? "text-success" : "text-danger";
        let estado = matricula.entregado != 0 ? "Entregado" : "Pendiente";
        let estadoColor = matricula.entregado != 0 ? "text-success" : "text-danger";
        let estadoIcon = matricula.entregado != 0 ? "fa-check" : "fa-clock";
        let estadoDisabled = matricula.saldo <= 0 ? "" : "disabled";

        let html = `<tr>
                        <td>${matricula.documento}</td>
                        <td>${matricula.estudiante}</td>
                        <td>${matricula.usuario}</td>
                        <td>${matricula.servicio}</td>
                        <td>${matricula.costo}</td>
                        <td>${matricula.primera_cuota}</td>
                        <td>${matricula.ultima_cuota}</td>
                        <td>${matricula.cancelado}</td>
                        <td class="${colorSaldo}">${matricula.saldo}</td>
                        <td class="${estadoColor}">
                            ${estado}<i class="fas ${estadoIcon}"></i>
                        </td>
                        <td>
                            <button class="btn btn-secondary btn-sm pago" 
                                data-codigo="${matricula.id}" 
                                data-documento="${matricula.documento}"
                                data-estudiante="${matricula.estudiante}"
                                data-saldo="${matricula.saldo}"
                                title="pago cuota"
                                ${disabled}
                                >
                                <i class="fas fa-money-bill-wave"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm entregar" 
                                data-codigo="${matricula.id}" 
                                data-documento="${matricula.documento}"
                                data-estudiante="${matricula.estudiante}"
                                title="Entregar Certificado"
                                ${estadoDisabled}
                                >
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </td>
                        <td>
                        <a href="#" class="btn btn-primary btn-sm"
                        data-toggle="modal" data-target="#pdfModal" 
                        data-pdf-url="${BASEURL}/pdf/detalle-pago-certificado-antecedentes/${matricula.id}/${user.us_codigo}">
                        <i class="fas fa-clipboard-list"></i>
                       </a>
                    </tr>`;
        return html;
    }

    function cargandoDatos() {
        $("#matriculaTable tbody").empty();
        $("#matriculaTable tbody").append(
            `<tr class="spinner-row">
                    <td colspan="10" align="center">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </div>
                    </td>
                </tr>`
        );
    }

    $(document).on("click", ".entregar", function (e) {
        e.preventDefault();
        codigoProgramacion = $(this).data("codigo");
        let documento = $(this).data("documento");
        let estudiante = $(this).data("estudiante");
        
        $("#nroDocumentoEntrega").html(documento);
        $("#nombreEstudianteEntrega").html(estudiante);
        $("#modalEntregarCertificado").modal("show");
    });

    $("#btnEntregar").click(function (e) {
        $.ajax({
            type: "PATCH",
            url: BASEURL + "/manager_certificado_antecedentes/" + codigoProgramacion,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                $("#modalEntregarCertificado").modal("hide");

                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    loadProgramacion(1, $('#buscarEstudiante').val());
                } else {
                    alertify.set("notifier", "position", "top-right");
                    alertify.error(response.message);
                }
            },
            error: function (xhr) {
                alertify.set("notifier", "position", "top-right");
                alertify.error(xhr.responseJSON.message);
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

    $(document).on("click", ".pago", function (e) {
        e.preventDefault();
        codigoProgramacion = $(this).data("codigo");
        let documento = $(this).data("documento");
        let estudiante = $(this).data("estudiante");
        let saldo = $(this).data("saldo");
        console.log({documento, estudiante});
        //$("#modalPagoTitle").html("Pago de Cuota - Cert: " + matricula);
        $("#modalPagoTitle").html("Pago de Cuota");
        $("#nroDocumento").html(documento);
        $("#nombreEstudiante").html(estudiante);
        $("#saldoCertificado").html(saldo);
        $("#modalPago").modal("show");
    });

    $("#btnPago").click(function (e) {
        let data = {
            codigo: codigoProgramacion,
            pc_monto: $("#pc_monto").val(),
            pc_tipo: $("#pc_tipo").val(),
            documento: $("#documento").val(),
        };
        $.ajax({
            type: "PUT",
            url: BASEURL + "/manager_certificado_antecedentes/" + codigoProgramacion,
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
                    loadProgramacion(1, $('#buscarEstudiante').val());
                    url=`${BASEURL}/pdf/comprobante-render/${response.data.cp_codigo}/${user.us_codigo}`;
                    $("#pdfModalLabel").html("Comprobante de Ingreso");
                    $('#pdfIframe').attr('src', url);
                    $('#pdfModal').modal('show');

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

    $("#btnRegistrar").click(function (e) {
        let data = {
            es_codigo: $('#es_codigo').val(),
            importe: importe.value,
        };
        $.ajax({
            type: "POST",
            url: BASEURL + "/manager_certificado_antecedentes/",
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
                $("#modalRegistrarCertificado").modal("hide");

                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success("Pago realizado correctamente");
                    $("#formPago").trigger("reset");
                    loadProgramacion(1, $('#buscarEstudiante').val());
                    url=`${BASEURL}/pdf/comprobante-render/${response.data.cp_codigo}/${user.us_codigo}`;
                    $("#pdfModalLabel").html("Comprobante de Ingreso");
                    $('#pdfIframe').attr('src', url);
                    $('#pdfModal').modal('show');

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

    $("#btnAgregar").click(function () {
        $("#formCertificado").trigger("reset");
        $("#modalRegistrarCertificado").modal("show");
    })

    $('.estudiante').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + '/manager_estudiante/autocomplete',
                dataType: "json",
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token // Pasar el token como parte de la cabecera de autorización
                },
                data: {
                    term: request.term // envía el término de búsqueda al servidor
                },
                success: function (resp) {
                    response(resp.data); // Envía los datos al widget Autocomplete
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        },
        select: function (event, ui) {
            $('#es_codigo').val(ui.item.id);
            $('#estudiante').val(ui.item.value);
        }
    });

    var importe = document.getElementById("importe");
    var saldo = document.getElementById("saldo");
    var precio = document.getElementById("precio");

    importe.addEventListener("input", (e) => {
        let importe = parseFloat(e.target.value) || 0;
        if (importe < precio.value) {
            saldo.value = precio.value - importe;
        } else {
            e.target.value = precio.value;
            saldo.value = 0;
        }
    })
});
