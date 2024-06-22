$(document).ready(function () {
    const BASEURL = window.apiUrl + "/api/admin_estudiante";
    const BASEURLPDF = window.apiUrl + "/api/pdf/credenciales-estudiante";
    const token = localStorage.getItem("token");
    const user = JSON.parse(localStorage.getItem("user"));

    var es_documento = document.getElementById("es_documento");
    var es_expedicion = document.getElementById("es_expedicion");
    var es_tipodocumento = document.getElementById("es_tipodocumento");
    var es_nombre = document.getElementById("es_nombre");
    var ape_paterno = document.getElementById("ape_paterno");
    var ape_materno = document.getElementById("ape_materno");
    var es_nacimiento = document.getElementById("es_nacimiento");
    var es_direccion = document.getElementById("es_direccion");
    var es_telefono = document.getElementById("es_celular");
    var es_correo = document.getElementById("es_correo");
    var es_observacion = document.getElementById("es_observacion");
    var es_foto = document.getElementById("es_foto");
    var es_codigo;

    loadEstudiantes(1, ""); // Cargar la primera página al cargar la página

    $("#btnBuscarEstudiante").click(function () {
        let term = $("#buscarEstudiante").val();
        loadEstudiantes(1, term);
    });

    function loadEstudiantes(page, term) {
        $.ajax({
            type: "GET",
            //url: BASEURL + '?page=' + page ,
            url: BASEURL + "?page=" + page + "&term=" + term,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                cargandoDatos();
                $("#paginationContainer").html("");
            },
            success: function (response) {
                $("#tbodyEstudiante").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(response.data, function (index, estudiante) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#estudianteTable tbody").append(
                        cargarTablaEstudiante(estudiante)
                    );
                });

                $("#paginationContainer").html(
                    generatePagination(response.pagination)
                ); // Imprimir la respuesta en la consola para depuración
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
    }

    function cargandoDatos() {
        $("#estudianteTable tbody").empty();
        $("#tbodyEstudiante").append(
            `<tr class="spinner-row">
                    <td colspan="11" align="center">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </div>
                    </td>
                </tr>`
        );
    }

    function generatePagination(response) {
        var paginationHtml = "";

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
    $("#pagination").on("click", "a", function (e) {
        e.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        loadEstudiantes(page, $("#buscarEstudiante").val());
    });

    function cargarTablaEstudiante(estudiante) {
        let html = `<tr>
                        <td><img src="${estudiante.foto}" class="img-perfil-tabla"></td>
                        <td>${estudiante.documento}</td>
                        <td>${estudiante.nombre}</td>
                        <td>${estudiante.apellido}</td>
                        <td>${estudiante.correo}</td>
                        <td>${estudiante.direccion}</td>
                        <td>${estudiante.celular}</td>
                        <td>${estudiante.edad}</td>
                        <td>${estudiante.usuario}</td>
                        <td><h5><span class="badge badge-${estudiante.color}">${estudiante.estado}</span></h5></td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm" title="Credenciales"
                             data-toggle="modal" data-target="#pdfModal" 
                             data-pdf-url="${BASEURLPDF}/${estudiante.id}/${user.us_codigo}">
                                <i class="fas fa-id-card"></i>
                            </a>
                        </td>
                        <td><button class="btn btn-secondary btn-sm editar" title="editar" data-codigo="${estudiante.id}"><i class="far fa-edit"></i></button></td>
                    </tr>`;
        return html;
    }

    $('#pdfModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activa el modal
        var pdfUrl = button.data('pdf-url'); // Extraer la URL del PDF desde data-pdf-url
        var modal = $(this);
        modal.find('#pdfIframe').attr('src', pdfUrl); // Asignar la URL del PDF al iframe
      });
    
    $('#btnCerrar').click(function(e){
        e.preventDefault;

        var modal = $(this);
        modal.find('#pdfIframe').attr('src', ''); // Asignar la URL del PDF al iframe
        
    });

    $(document).on("click", ".editar", function (e) {
        e.preventDefault();
        es_codigo = $(this).data("codigo");
        getEstudiante(es_codigo);
    });

    function getEstudiante(id) {
        $.ajax({
            url: BASEURL + "/" + id + "/show",
            type: "GET",
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
                if (response.status) {
                    estudiante = response.data;
                    $("#es_codigo").val(estudiante.id);
                    $("#es_documento").val(estudiante.documento);
                    $("#es_expedicion").val(estudiante.expedicion);
                    $("#es_tipodocumento").val(estudiante.tipo_documento);
                    $("#es_nacimiento").val(estudiante.fecha_nacimiento);
                    $("#es_nombre").val(estudiante.nombre);
                    $("#ape_paterno").val(estudiante.ape_paterno);
                    $("#ape_materno").val(estudiante.ape_materno);
                    $("#es_direccion").val(estudiante.direccion);
                    $("#es_celular").val(estudiante.celular);
                    $("#es_observacion").val(estudiante.observacion);
                    $("#es_correo").val(estudiante.correo);
                    if (estudiante.genero == 1) {
                        document.getElementById("masculino").checked = true;
                    } else {
                        document.getElementById("femenino").checked = true;
                    }
                    $("#es_foto").val(estudiante.foto);
                    $("#imagen").attr("src", estudiante.foto);
                    $("#edad").val(estudiante.edad);

                    $("#modalEditarEstudiante").modal("show");
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    }

    $("#btnGuardar").click(function () {
        updateEstudiante(es_codigo);
    });

    function updateEstudiante(id) {
        let es_genero = document.querySelector(
            'input[name="es_genero"]:checked'
        );
        var estudiante = {
            es_documento: es_documento.value,
            es_expedicion: es_expedicion.value,
            es_tipodocumento: es_tipodocumento.value,
            es_nombre: es_nombre.value,
            es_nacimiento: es_nacimiento.value,
            es_genero: es_genero.value,
            es_direccion: es_direccion.value,
            es_celular: es_telefono.value,
            es_correo: es_correo.value,
            es_observacion: es_observacion.value,
            es_foto: es_foto.value,
            ape_paterno: ape_paterno.value,
            ape_materno: ape_materno.value,
        };
        console.log(estudiante);
        $.ajax({
            url: BASEURL + "/" + id,
            type: "PUT",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
            },
            data: estudiante,
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (response) {
                $("#overlay").hide();
                if (response.status) {
                    $("#modalEditarEstudiante").modal("hide");
                    loadEstudiantes(1);
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                }
            },
            error: function (xhr) {
                $("#overlay").hide();
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
});
