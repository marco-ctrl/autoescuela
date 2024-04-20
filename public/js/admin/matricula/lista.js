$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem('user'));
    const BASEURL = '/autoescuela/public/api/admin_matricula';
    const URLHORARIO = '/autoescuela/public/admin/horario-matricula/';
    const URLPDF = '/autoescuela/public/api/pdf/';

    const token = localStorage.getItem('token');

    loadMatriculas(1); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadMatriculas(page) {
        $.ajax({
            type: "GET",
            url: BASEURL + '?page=' + page,
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (response) {
                $('#overlay').hide();
                $('#matriculaTable tbody').empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(response.data, function (index, matricula) {
                    // Agregar fila a la tabla con los datos de la cita
                    $('#matriculaTable tbody').append(cargarTablaMatricula(matricula));
                });

                $('#paginationContainer').html(generatePagination(response.pagination)); // Imprimir la respuesta en la consola para depuración
            },
            error: function (xhr, status, error) {
                $('#overlay').hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            }
        });
    }

    function generatePagination(response) {
        var paginationHtml = '';

        // Enlace "Previous"
        if (response.prev_page_url !== null) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="' + response.prev_page_url + '">Anterior</a></li>';
        } else {
            paginationHtml += '<li class="page-item disabled"><span class="page-link">Anterior</span></li>';
        }

        // Enlaces de páginas
        $.each(response.links, function (index, link) {
            if (index !== 0 && index !== (response.links.length - 1)) {
                if (link.active) {
                    paginationHtml += '<li class="page-item active"><span class="page-link">' + link.label + '</span></li>';
                } else {
                    paginationHtml += '<li class="page-item"><a class="page-link" href="' + link.url + '">' + link.label + '</a></li>';
                }
            }
        });

        // Enlace "Next"
        if (response.next_page_url !== null) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="' + response.next_page_url + '">Siguiente</a></li>';
        } else {
            paginationHtml += '<li class="page-item disabled"><span class="page-link">Siguiente</span></li>';
        }

        return paginationHtml;
    }

    // Manejar clics en los enlaces de paginación
    $(document).on('click', '#paginationContainer a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadMatriculas(page);
    });

    function cargarTablaMatricula(matricula) {
        let html = `<tr>
                        <td><img src="${matricula.foto}" width="40" class="img-profile rounded-circle"></td>
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
                        <td>${matricula.costo}</td>
                        <td>${matricula.cancelado}</td>
                        <td>${matricula.saldo}</td>
                        <td>${matricula.fecha_inicio}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Accion
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="${URLHORARIO}${matricula.id}"><i class="fas fa-calendar-alt"></i> Horario Matricula</a>
                                    <a class="dropdown-item" href="${URLPDF}kardex/${matricula.id}/${user.us_codigo}" target="_blank"><i class="fas fa-file-alt"></i> kardex</a>
                                    <a class="dropdown-item" href="${URLPDF}matricula/${matricula.id}/${user.us_codigo}/A4" target="_blank"><i class="fas fa-file-alt"></i> PDF A4</a>
                                    <a class="dropdown-item" href="${URLPDF}matricula/${matricula.id}/${user.us_codigo}/ticket" target="_blank"><i class="fas fa-file-alt"></i> PDF ticket</a>
                                </div>
                            </div>
                        </td>
                    </tr>`;
        return html;
    }
});
