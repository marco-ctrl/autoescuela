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
        loadEstudiantes(page, $("#buscarEstudiante").val());
    });

    function cargarTablaMatricula(matricula) {
        let html = `<tr>
                        <td><img src="${matricula.foto}" class="img-perfil-tabla"></td>
                        <td>${matricula.nro_kardex}</td>
                        <td>${matricula.fecha_inscripcion}</td>
                        <td>${matricula.documento}</td>
                        <td>${matricula.expedicion}</td>
                        <td>${matricula.nombres} ${matricula.apellidos}</td>
                        <td>${matricula.usuario}</td>
                        <td>${matricula.categoria}</td>
                        <td>${matricula.sede}</td>
                        <td>${matricula.curso}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" title="Historial"
                                data-toggle="modal" data-target="#pdfModal"
                                data-title="Historial"
                                data-pdf-url="${URLPDF}kardex/${matricula.id}/${user.us_codigo}">
                                <i class="fas fa-file-alt"></i>
                            </button>
                        </td>
                    </tr>`;
        return html;
    }

    function cargandoDatos() {
        $("#matriculaTable tbody").empty();
        $("#matriculaTable tbody").append(
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

    listarSede();

    function listarSede() {
        $.ajax({
            url: BASEURL + "/admin_sede",
            type: "get",
            dataType: "json",
            success: function (response) {
                var select = $("#sede");

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
});
