$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLHORARIO = window.apiUrl + "/admin/horario-matricula/";
    const URLPDF = window.apiUrl + "/api/pdf/";

    var codigoMatricula = 0;

    const token = localStorage.getItem("token");

    let timeout = null;

    $("#buscarEstudiante").on("keyup", function () {
        if (timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            let term = $("#buscarEstudiante").val();
            loadMatriculas(1, term);
        }, 2000);
    });

    $("#btnBuscarEstudiante").click(function () {
        let term = $("#buscarEstudiante").val();
        loadMatriculas(1, term);
    });

    loadMatriculas(1, ""); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadMatriculas(page, term) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/admin_matricula?page=" + page + "&term=" + term,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                cargandoDatos();
            },
            success: function (response) {
                $("#overlay").hide();
                $("#matriculaTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(response.data, function (index, matricula) {
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
        loadMatriculas(page, "");
    });

    function cargarTablaMatricula(matricula) {
        let html = `<tr>
                        <td><img src="${matricula.foto}" class="img-perfil-tabla"></td>
                        <td>${matricula.nro_kardex}</td>
                        <td>${matricula.fecha_inscripcion}</td>
                        <td>${matricula.documento}</td>
                        <td>${matricula.expedicion}</td>
                        <td>${matricula.nombres}</td>
                        <td>${matricula.ape_paterno}</td>
                        <td>${matricula.ape_materno}</td>
                        <td>${matricula.usuario}</td>
                        <td>${matricula.categoria}</td>
                        <td>${matricula.sede}</td>
                        <td>${matricula.curso}</td>
                        <td>${matricula.numClases}</td>
                        <td>${matricula.costo_curso}</td>
                        <td>${matricula.costo_evaluacion}</td>
                        <td>${matricula.costo}</td>
                        <td>${matricula.cancelado}</td>
                        <td>${matricula.saldo}</td>
                        <td>${matricula.fecha_inicio}</td>
                        <td>${matricula.fecha_evaluacion}</td>
                        <td>${matricula.sede_evaluacion}</td>
                       <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Accion
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="${URLHORARIO}${matricula.id}"><i class="fas fa-calendar-alt"></i> Horario Matricula</a>
                                    <a class="dropdown-item editar" href="#" 
                                        data-codigo="${matricula.id}" 
                                        data-matricula="${matricula.nro_matricula}"
                                        data-evaluacion="${matricula.fecha_evaluacion}"
                                        data-estudiante="${matricula.nombres} ${matricula.ape_paterno} ${matricula.ape_materno}"
                                        data-categoria="${matricula.categoria}"
                                        data-curso="${matricula.curso}"
                                        data-edad="${matricula.edad}"
                                    ><i class="fas fa-edit"></i> Editar Matricula</a>
                                    <a class="dropdown-item evaluacion" href="#" 
                                        data-codigo="${matricula.id}" 
                                        data-matricula="${matricula.nro_matricula}"
                                        data-evaluacion="${matricula.fecha_evaluacion}"
                                        data-sede_evaluacion="${matricula.sede_evaluacion}"
                                        data-estudiante="${matricula.nombres} ${matricula.ape_paterno} ${matricula.ape_materno}"
                                        data-categoria="${matricula.categoria}"
                                    ><i class="fas fa-calendar-alt"></i> Fecha Evaluacion</a>
                                    <a class="dropdown-item agregar-evaluacion" href="#" 
                                        data-codigo="${matricula.id}" 
                                        data-matricula="${matricula.nro_matricula}"
                                        data-evaluacion="${matricula.fecha_evaluacion}"
                                        data-estudiante="${matricula.nombres} ${matricula.ape_paterno} ${matricula.ape_materno}"
                                        data-categoria="${matricula.categoria}"
                                        data-curso="${matricula.curso}"
                                        data-edad="${matricula.edad}"
                                    ><i class="fas fa-calendar-plus"></i> Adicionar Evaluacion</a>
                                    <a class="dropdown-item agregar-curso" href="#" 
                                        data-codigo="${matricula.id}" 
                                        data-matricula="${matricula.nro_matricula}"
                                        data-evaluacion="${matricula.fecha_evaluacion}"
                                        data-estudiante="${matricula.nombres} ${matricula.ape_paterno} ${matricula.ape_materno}"
                                        data-categoria="${matricula.categoria}"
                                        data-curso="${matricula.curso}"
                                        data-edad="${matricula.edad}"
                                    ><i class="fas fa-folder-plus"></i> Adicionar Curso</a>
                                    <a href="#" class="dropdown-item" title="PDF A4"
                                        data-toggle="modal" data-target="#pdfModal"
                                        data-title="Kardex"
                                        data-pdf-url="${URLPDF}kardex/${matricula.id}/${user.us_codigo}">
                                        <i class="fas fa-file-alt"></i> kardex</a>
                                    </a>
                                    <a href="#" class="dropdown-item" title="PDF A4"
                                        data-toggle="modal" data-target="#pdfModal"
                                        data-title="PDF A4"
                                        data-pdf-url="${URLPDF}matricula/${matricula.id}/${user.us_codigo}/A4">
                                        <i class="fas fa-file-alt"></i> PDF A4
                                    </a>
                                    <a href="#" class="dropdown-item" title="Matricula Ticket"
                                        data-toggle="modal" data-target="#pdfModal"
                                        data-title="Matricula Ticket"
                                        data-pdf-url="${URLPDF}matricula/${matricula.id}/${user.us_codigo}/ticket">
                                        <i class="fas fa-file-alt"></i> PDF ticket
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>`;
        return html;
    }

    function cargandoDatos() {
        $("#matriculaTable tbody").empty();
        $("#matriculaTable tbody").append(
            `<tr class="spinner-row">
                    <td colspan="19" align="center">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </div>
                    </td>
                </tr>`
        );
    }
    
    $(document).on("click", ".agregar-curso", function (e) {
        e.preventDefault();
        codigoMatricula = $(this).data("codigo");
        let matricula = $(this).data("matricula");
        $("#estudianteCurso").html($(this).data("estudiante"));
        $("#categoriaCurso").html($(this).data("categoria"));
        $("#cursoCurso").html($(this).data("curso"));
        $("#edadCurso").html($(this).data("edad"));
        $("#modalEditarMatriculaTitle").html("Editar Matricula: " + matricula);

        //listarCategoria($(this).data("edad"));
        $("#formEditarCurso").trigger("reset");
        $("#modalAgregarCurso").modal("show");
    });

    $("#btnAgregarCurso").click(function (e) {
        e.preventDefault();

        let data = {
            matricula: codigoMatricula,
            cu_codigo: $("#cu_codigo").val(),
            importe: $("#importe").val(),
            ma_costo_curso: $("#ma_costo_curso").val(),
            ma_duracion: $("#ma_duracion").val(),
        };

        $.ajax({
            type: "PUT",
            url:
                BASEURL +
                "/admin_matricula/agregar-curso/" +
                codigoMatricula,
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
                $("#modalAgregarCurso").modal("hide");
                loadMatriculas(1, $("#buscarEstudiante").val());
                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    var url = `${URLPDF}comprobante-render/${response.data.cp_codigo}/${user.us_codigo}`;

                    $("#pdfIframe").attr("src", url);
                    $("#pdfModal").modal("show");
                    $("#formEditarCurso").trigger("reset");
                } else {
                    console.error(response.message);
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
        //console.log(data);
    });

    $(document).on("click", ".editar", function (e) {
        e.preventDefault();
        codigoMatricula = $(this).data("codigo");
        let matricula = $(this).data("matricula");
        $("#estudianteMatricula").html($(this).data("estudiante"));
        $("#categoriaMatricula").html($(this).data("categoria"));
        $("#cursoMatricula").html($(this).data("curso"));
        $("#edadMatricula").html($(this).data("edad"));
        $("#modalEditarMatriculaTitle").html("Editar Matricula: " + matricula);
        $("#formEditarMatricula").trigger("reset");
        listarCategoria($(this).data("edad"));
        $("#modalEditarMatricula").modal("show");
    });

    $("#btnEditarMatricula").click(function (e) {
        e.preventDefault();

        let data = {
            matricula: codigoMatricula,
            se_codigo: $("#sedeEditar").val(),
            ma_categoria: $("#ma_categoria").val(),
        };

        $.ajax({
            type: "PUT",
            url: BASEURL + "/admin_matricula/edit/" + codigoMatricula,
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
                $("#modalEditarMatricula").modal("hide");
                loadMatriculas(1, $("#buscarEstudiante").val());
                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    $("#formEditarMatricula").trigger("reset");
                } else {
                    console.error(response.message);
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

    $(document).on("click", ".agregar-evaluacion", function (e) {
        e.preventDefault();
        codigoMatricula = $(this).data("codigo");
        let matricula = $(this).data("matricula");
        $("#estudianteEvaluacion").html($(this).data("estudiante"));
        $("#categoriaEvaluacion").html($(this).data("categoria"));
        $("#cursoEvaluacion").html($(this).data("curso"));
        $("#formAgregarEvaluacion").trigger("reset");
        $("#modalAgregarEvaluacionTitle").html(
            "Agregar Evaluacion de Matricula: " + matricula
        );
        $("#modalAgregarEvaluacion").modal("show");
    });

    $("#btnAgregarEvaluacion").click(function (e) {
        e.preventDefault();

        let data = {
            matricula: codigoMatricula,
            costo: $("#costoEvaluacion").val(),
            importe: $("#importeEvaluacion").val(),
        };

        $.ajax({
            type: "PUT",
            url:
                BASEURL +
                "/admin_matricula/agregar-evaluacion/" +
                codigoMatricula,
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
                $("#modalAgregarEvaluacion").modal("hide");
                loadMatriculas(1, $("#buscarEstudiante").val());
                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    var url = `${URLPDF}comprobante-render/${response.data.cp_codigo}/${user.us_codigo}`;

                    $("#pdfIframe").attr("src", url);
                    $("#pdfModal").modal("show");
                    $("#formAgregarEvaluacion").trigger("reset");
                } else {
                    console.error(response.message);
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
        //console.log(data);
    });

    $(document).on("click", ".evaluacion", function (e) {
        e.preventDefault();
        codigoMatricula = $(this).data("codigo");
        let matricula = $(this).data("matricula");
        $("#estudiante").val($(this).data("estudiante"));
        $("#categoria").val($(this).data("categoria"));
        $("#fecha").val($(this).data("evaluacion"));
        $("#sede").val($(this).data("sede_evaluacion"));
        $("#modalEvaluacionTitle").html(
            "Evaluacion de Matricula: " + matricula
        );
        $("#modalEvaluacion").modal("show");
    });

    $("#btnEvaluacion").click(function (e) {
        e.preventDefault();
        $('#mensajeConfirmacion').empty();
        let estudiante = $("#estudiante").val();
        let fecha = $("#fecha").val();
        let sede = $("#sede").val();
        let categoria = $("#categoria").val();
        console.log(estudiante, fecha, sede, categoria);
        
        if (fecha == "" || sede == "") {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Debe ingresar la fecha y la sede de la evaluacion");
            return;
        }
        
        $('#mensajeConfirmacion').append(
            `<p>¿Esta seguro de asignar esta fecha y hora de evaluacion para este 
            estudiante ${estudiante}?</p>
            <p><strong>Categoria: </strong>${categoria}</p>
            <p><strong>Sede: </strong>${sede}</p>
            <p><strong>Fecha: </strong>${fecha}</p>`
        );
        $('#confirmationModal').modal('show');
    });

    $("#confirmAction").click(function (e) {
        e.preventDefault();
        asignarEvaluacion(codigoMatricula);
    })

    function asignarEvaluacion(codigoMatricula) {
        let data = {
            codigo: codigoMatricula,
            fecha: $("#fecha").val(),
            sede: $("#sede").val(),
        };
        $.ajax({
            type: "PUT",
            url: BASEURL + "/admin_matricula/evaluacion/" + codigoMatricula,
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
                $("#modalEvaluacion").modal("hide");
                $('#confirmationModal').modal('hide');
                loadMatriculas(1, $('#buscarEstudiante').val());
                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    $("#formEvaluacion").trigger("reset");
                } else {
                    console.error(response.message);
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
    }

    listarSede();

    function listarSede() {
        $.ajax({
            url: BASEURL + "/admin_sede",
            type: "get",
            dataType: "json",
            success: function (response) {
                var select = $(".sede");

                if (response.status) {
                    $.each(response.data, function (i, item) {
                        select.append(
                            $("<option></option>")
                                .attr("value", item.se_descripcion)
                                .text(item.se_descripcion)
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

    $("#pdfModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget); // Botón que activa el modal
        var pdfUrl = button.data("pdf-url"); // Extraer la URL del PDF desde data-pdf-url
        var modal = $(this);
        modal.find("#pdfModalLabel").html(button.data("title")); // Asignar el título del modal
        modal.find("#pdfIframe").attr("src", pdfUrl); // Asignar la URL del PDF al iframe
    });

    $(".cancelar").click(function (e) {
        e.preventDefault;
        var modal = $(this);
        modal.find("#pdfIframe").attr("src", ""); // Asignar la URL del PDF al iframe
    });
    
    function listarCategoria(edad) {
        $.ajax({
            url: BASEURL + "/admin_categoria/" + edad,
            type: "get",
            dataType: "json",
            success: function (response) {
                var select = $("#ma_categoria");    
                $("#ma_categoria").empty();
                if (response.status) {
                    // Itera sobre el arreglo 'data' dentro de la respuesta
                    $.each(response.data, function (i, item) {
                        select.append(
                            $("<option></option>")
                                .attr("value", item.ca_descripcion)
                                .text(item.ca_descripcion)
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
    
    var ma_duracion = document.getElementById("ma_duracion");
    var ma_costo_curso = document.getElementById("ma_costo_curso");
    
    var pagado = document.getElementById("pagado");
    var importe = document.getElementById("importe");
    var saldo = document.getElementById("saldo");
    var saldoInicial = 0;

    $("#curso").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + "/admin_curso/autocomplete",
                dataType: "json",
                data: {
                    term: request.term,
                },
                success: function (resp) {
                    response(resp.data);
                },
            });
        },
        select: function (event, ui) {
            $("#cu_codigo").val(ui.item.id);
            console.log({ costo: ui.item.costo, duracion: ui.item.duracion });

            ma_costo_curso.value = ui.item.costo;
            ma_duracion.value = ui.item.duracion;

            importe.disabled = false;
            importe.value = 0;

            let costoCurso = parseFloat(ma_costo_curso.value) || 0;

            saldo.value = calcularSaldo(costoCurso, importe.value);
            ma_duracion.disabled = false;
            ma_costo_curso.disabled = false;
        },
    });
    
    importe.addEventListener("input", (e) => {
        let costoCurso = parseFloat(ma_costo_curso.value) || 0;
        let importeValue = parseFloat(importe.value) || 0;
        saldo.value = calcularSaldo(costoCurso, importeValue);

        if (importeValue > costoCurso) {
            importe.value = costoCurso;
            saldo.value = 0;
        }
    })

    ma_costo_curso.addEventListener("input", (e) => {
        let costoCurso = parseFloat(ma_costo_curso.value) || 0;
        let importeValue = parseFloat(importe.value) || 0;
        saldo.value = calcularSaldo(costoCurso, importeValue);
    })

    function calcularSaldo(costo, importe){
        return saldo.value = costo - importe;
    }
});
