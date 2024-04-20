$(document).ready(function () {
    $('#modalRegistrarEstudiante').modal('show');

    var token = localStorage.getItem('token');
    const BASEURL = '/autoescuela/public/api';
    const URLPDF = '/autoescuela/public/api/pdf/';
    const user = JSON.parse(localStorage.getItem('user'));

    var ma_duracion = document.getElementById('ma_duracion');
    var ma_costo = document.getElementById('ma_costo');
    var pagado = document.getElementById('pagado');
    var importe = document.getElementById('importe');
    var saldo = document.getElementById('saldo');
    var saldoInicial = 0;
    
    listarSalidas();
    listarSede();
    listarCategoria();

    function listarSalidas() {
        $.ajax({
            url: BASEURL + '/admin_salida',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var select = $('#salida');

                if (response.status) {
                    $.each(response.data, function (i, item) {
                        select.append($('<option></option>').attr('value', item.pa_codigo).text(item.pa_descripcion));
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

    function listarPlacaPorSalida(pa_codigo) {
        $.ajax({
            url: BASEURL + '/admin_ambiente/salida/' + pa_codigo,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#am_codigo').empty().append('<option value="">Selecciona una placa</option>');

                if (response.status) {
                    $.each(response.data, function (i, item) {
                        $('#am_codigo').append($('<option></option>').attr('value', item.am_codigo).text(item.am_descripcion));
                    });
                } else {
                    console.log('La respuesta del servidor no tiene un estado exitoso.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error al cargar las placas: ', textStatus);
            }
        });
    }

    function listarSede() {
        $.ajax({
            url: BASEURL + '/admin_sede',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var select = $('#se_codigo');

                if (response.status) {
                    $.each(response.data, function (i, item) {
                        select.append($('<option></option>').attr('value', item.se_codigo).text(item.se_descripcion));
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

    function listarCategoria() {
        $.ajax({
            url: BASEURL + '/admin_categoria',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var select = $('#ma_categoria');

                if (response.status) {
                    // Itera sobre el arreglo 'data' dentro de la respuesta
                    $.each(response.data, function (i, item) {
                        select.append($('<option></option>').attr('value', item.ca_descripcion).text(item.ca_descripcion));
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

    $('#salida').change(function () {
        var pa_codigo = $(this).val();

        if (pa_codigo) {
            listarPlacaPorSalida(pa_codigo);
        } else {
            $('#am_codigo').empty().append('<option value="">Selecciona una placa</option>');
        }
    });

    $('#curso').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + '/admin_curso/autocomplete',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (resp) {
                    response(resp.data);
                }
            });
        },
        select: function (event, ui) {
            $('#cu_codigo').val(ui.item.id);

            asignarSaldo(ui.item.id);
            //console.log(ui.item.id);
        }
    });

    function asignarSaldo(cu_codigo) {
        $.ajax({
            url: BASEURL + '/admin_curso/' + cu_codigo,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status) {
                    ma_costo.value = response.data.cu_costo;
                    saldo.value = ma_costo.value;
                    saldoInicial = ma_costo.value;
                    ma_duracion.value = response.data.cu_duracion;

                    importe.disabled = false;
                    importe.value = 0;
                    pagado.disabled = false;
                    ma_duracion.disabled = false;
                    ma_costo.disabled = false;
                } else {
                    console.log('La respuesta del servidor no tiene un estado exitoso.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar los datos: ', textStatus, errorThrown);
            }
        });
    }

    pagado.addEventListener('change', (e) => {

        if (e.target.checked) {
            importe.value = saldo.value;
            importe.disabled = true;
            saldo.value = '0';
            pagado.value = true;
        } else {
            importe.disabled = false;
            saldo.value = saldoInicial;
            importe.value = '0';
            pagado.value = false;
        }
    });

    importe.addEventListener('input', (e) => {
        let importe = parseFloat(e.target.value) || 0;
        if (importe > ma_costo.value) {
            importe = ma_costo.value;
            e.target.value = ma_costo.value;
        }

        calcularSaldo(importe);
    });

    ma_costo.addEventListener('input', (e) => {
        let ma_costo = parseFloat(e.target.value) || 0;

        saldo.value = ma_costo;
        saldoInicial = ma_costo;

        importe.value = '0';
    });

    function calcularSaldo(importe) {
        if (importe > saldoInicial) {
            importe = saldoInicial;
            console.log(e.target.value);
            e.target.value = saldoInicial;
        }

        saldo.value = saldoInicial - importe;
    }

    $('#form').submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();
        // Recolectar los valores de los campos del formulario
        var data = {
            estudiante: $('#estudiante').val(),
            curso: $('#curso').val(),
            es_codigo: $('#es_codigo').val(),
            cu_codigo: $('#cu_codigo').val(),
            ma_costo: $('#ma_costo').val(),
            ma_duracion: $('#ma_duracion').val(),
            salida: $('#salida').val(),
            am_codigo: $('#am_codigo').val(),
            se_codigo: $('#se_codigo').val(),
            ma_categoria: $('#ma_categoria').val(),
            importe: $('#importe').val(),
            pagado: $('#pagado').is(':checked'),
            saldo: $('#saldo').val(),
            detalle_recojo: $('#detalle_recojo').val()
        };
        $.ajax({
            type: 'POST',
            url: BASEURL + '/admin_matricula/store',
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
                if (response.status) {
                    let matricula = response.data;
                    $('#successModal').modal('show');
                
                    $('#pdfA4').attr('href', `${URLPDF}matricula/${matricula.ma_codigo}/${user.us_codigo}/A4`);
                    $('#pdfTicket').attr('href', `${URLPDF}matricula/${matricula.ma_codigo}/${user.us_codigo}/ticket`);
    
                    $('#acceptBtn').click(function () {
                        window.location.href = '/autoescuela/public/admin/horario-matricula/' + response.data.ma_codigo;
                    });    
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
        });
    });
});