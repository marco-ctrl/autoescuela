$(document).ready(function () {

    const BASEURL = '/autoescuela/public/api/admin_estudiante';
    const BASEURLPDF = 'autoescuela/public/api/pdf/credenciales-estudiante';
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user'));
    
    loadEstudiantes(1); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadEstudiantes(page) {
        $.ajax({
            type: "GET",
            url: BASEURL + '?page=' + page ,
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (response) {
                $('#overlay').hide();
                $('#estudianteTable tbody').empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(response.data, function (index, estudiante) {
                    // Agregar fila a la tabla con los datos de la cita
                    $('#estudianteTable tbody').append(cargarTablaEstudiante(estudiante));
                });

                $('#paginationContainer').html(generatePagination(response.pagination)); // Imprimir la respuesta en la consola para depuración
            },
            error: function (xhr, status, error) {
                
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
        $.each(response.links, function(index, link) {
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
    $(document).on('click', '#paginationContainer a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadEstudiantes(page);
    });

    function cargarTablaEstudiante(estudiante)
    {
        let html = `<tr>
                        <td><img src="${estudiante.foto}" width="40" class="img-profile rounded-circle"></td>
                        <td>${estudiante.documento}</td>
                        <td>${estudiante.nombre}</td>
                        <td>${estudiante.apellido}</td>
                        <td>${estudiante.correo}</td>
                        <td>${estudiante.direccion}</td>
                        <td>${estudiante.celular}</td>
                        <td>${estudiante.edad}</td>
                        <td>${estudiante.usuario}</td>
                        <td><h5><span class="badge badge-${estudiante.color}">${estudiante.estado}</span></h5></td>
                        <td><a href="/${BASEURLPDF}/${estudiante.id}/${user.us_codigo}"
                        target="_blank" 
                            class="btn btn-primary btn-sm">Credencial</a></td>
                        <td><a href="/autoescuela/public/admin/estudiante/${estudiante.id}" 
                            class="btn btn-primary btn-sm">Ver</a></td>
                    </tr>`;
        return html;
    }
});
