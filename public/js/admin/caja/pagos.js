$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem('user'));
    const BASEURL = window.apiUrl + '/api';
    const URLHORARIO = window.apiUrl + '/admin/horario-matricula/';
    const URLPDF = window.apiUrl + '/api/pdf/';

    var codigoMatricula = 0;

    const token = localStorage.getItem('token');

    loadMatriculas(1); // Cargar la primera página al cargar la página

    // Función para cargar los datos de las citas
    function loadMatriculas(page) {
        $.ajax({
            type: "GET",
            url: BASEURL + '/admin_pago/listar-matricula?page=' + page,
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (response) {
                $('#overlay').hide();
               let data = response.data.filter(function (item) {
                    return item.saldo > 0;
               })
               $('#matriculaTable tbody').empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(data, function (index, matricula) {
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

        let disabled = matricula.saldo == 0 ? 'disabled' : '';

        let html = `<tr>
                        <td>${matricula.matricula}</td>
                        <td>${matricula.documento}</td>
                        <td>${matricula.estudiante}</td>
                        <td>${matricula.usuario}</td>
                        <td>${matricula.servicio}</td>
                        <td>${matricula.costo}</td>
                        <td>${matricula.inscripcion}</td>
                        <td>${matricula.primera_cuota}</td>
                        <td>${matricula.ultima_cuota}</td>
                        <td>${matricula.cancelado}</td>
                        <td>${matricula.saldo}</td>
                        <td>
                            <button class="btn btn-success pago" 
                                data-codigo="${matricula.id}" 
                                data-matricula="${matricula.matricula}"
                                title="pago cuota"
                                ${disabled}
                                >
                                <i class="fas fa-money-bill-wave"></i>
                            </button>
                        </td>
                    </tr>`;
        return html;
    }

    $(document).on('click', '.pago', function (e) {
        e.preventDefault();
        codigoMatricula = $(this).data('codigo');
        let matricula = $(this).data('matricula');
        $('#modalPagoTitle').html('Pago de Cuota - Matricula: ' + matricula);
        $('#modalPago').modal('show');
    });

    $('#btnPago').click(function (e) {
        let data = {
            codigo: codigoMatricula,
            pc_monto: $('#pc_monto').val(),
            pc_tipo: $('#pc_tipo').val(),
            documento: $('#documento').val(),
        }
        $.ajax({
            type: "POST",
            url: BASEURL + '/admin_pago',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token // Pasar el token como parte de la cabecera de autorización
            },
            data: data,
            beforeSend: function () {
                $('#overlay').show();
            },
            complete: function () {
                $('#overlay').hide();
            },
            success: function (response) {
                $('#modalPago').modal('hide');
                
                if (response.status) {
                    alertify.set('notifier', 'position', 'top-right')
                    alertify.success(response.message);
                    $('#formPago').trigger('reset');
                    loadMatriculas(1);
                }
                else{
                    alertify.set('notifier', 'position', 'top-right')
                    alertyfy.error(response.message);
                }
                
            },
            error: function (xhr) {
                console.error('Error al enviar datos:', xhr.responseJSON);

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.each(xhr.responseJSON.errors, function (key, value) {
                    var inputField = $('#' + key);
                    inputField.addClass('is-invalid');

                    var errorFeedback = $('<div class="invalid-feedback"></div>').text(value[0]); // Asume que quieres mostrar solo el primer mensaje de error
                    inputField.after(errorFeedback);
                });
            }
        })
    });

    listarComprobante();

    function listarComprobante() {
        $.ajax({
            url: BASEURL + '/admin_comprobante',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var select = $('#documento');

                if (response.status) {
                    $.each(response.data, function (i, item) {
                        select.append($('<option></option>').attr('value', item.cb_descripcion).text(item.cb_descripcion));
                    });
                } else {
                    console.log('La respuesta del servidor no tiene un estado exitoso.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar los datos: ', textStatus, errorThrown);
            }
        });
    }
});
