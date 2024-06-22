$(document).ready(function () {
    $('#modalRegistrarEstudiante').modal('show');

    var token = localStorage.getItem('token');
    const BASEURL = window.apiUrl + '/api';
    const URLPDF = window.apiUrl + '/api/pdf/';
    const user = JSON.parse(localStorage.getItem('user'));

    var ma_duracion = document.getElementById('ma_duracion');
    var ma_costo_curso = document.getElementById('ma_costo_curso');
    var ma_costo_evaluacion = document.getElementById('ma_costo_evaluacion');
    
    var pagado = document.getElementById('pagado');
    var evaluacion = document.getElementById('evaluacion');
    var importe = document.getElementById('importe');
    var saldo = document.getElementById('saldo');
    var saldoInicial = 0;
    
    listarSalidas();
    listarSede();
    
    function listarSalidas() {
        $.ajax({
            url: BASEURL + '/manager_salida',
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
            url: BASEURL + '/manager_ambiente/salida/' + pa_codigo,
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
            url: BASEURL + '/manager_sede',
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
                url: BASEURL + '/manager_curso/autocomplete',
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
            url: BASEURL + '/manager_curso/' + cu_codigo,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status) {
                    ma_costo_curso.value = response.data.cu_costo;
                    ma_costo_evaluacion.value = response.data.cu_costo_evaluacion;
                    saldo.value = ma_costo_curso.value;
                    saldoInicial = ma_costo_curso.value;
                    ma_duracion.value = response.data.cu_duracion;

                    importe.disabled = false;
                    importe.value = 0;
                    pagado.disabled = false;
                    ma_duracion.disabled = false;
                    ma_costo_curso.disabled = false;
                } else {
                    console.error(response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar los datos: ', textStatus, errorThrown);
            }
        });
    }

    pagado.addEventListener('change', (e) => {
        
        let saldoTotal=0;

        if(evaluacion.checked)
        {
            saldoTotal = (parseFloat(ma_costo_evaluacion.value) || 0 ) + (parseFloat(ma_costo_curso.value) || 0 );
        }
        else{
            saldoTotal = parseFloat(ma_costo_curso.value) || 0;
        }
        
        if (e.target.checked) {
            importe.value = saldoTotal;
            importe.disabled = true;
            saldo.value = '0';
            pagado.value = true;
        } else {
            importe.disabled = false;
            saldo.value = saldoTotal;
            importe.value = '0';
            pagado.value = false;
        }
    });

    evaluacion.addEventListener('change', (e) => {

        if (e.target.checked) {
            ma_costo_evaluacion.disabled = false;
            evaluacion.value = 1;
            saldo.value = (parseFloat(ma_costo_curso.value) + parseFloat(ma_costo_evaluacion.value)) - (parseFloat(importe.value) || 0);
        } else {
            ma_costo_evaluacion.disabled = true;
            evaluacion.value = 0;
            saldo.value = parseFloat(ma_costo_curso.value) - (parseFloat(importe.value) || 0);
        
        }
    });

    importe.addEventListener('input', (e) => {
        let importe = parseFloat(e.target.value) || 0;
        calcularSaldo(importe);
    });

    ma_costo_curso.addEventListener('input', (e) => {
        let ma_costo_curso = parseFloat(e.target.value) || 0;

        if(evaluacion.checked){
            saldo.value = parseFloat(ma_costo_evaluacion.value) + parseFloat(ma_costo_curso);
        }
        else{
            saldo.value = ma_costo_curso;
        }
        
        saldoInicial = ma_costo_curso;
        importe.value = '0';
    });

    ma_costo_evaluacion.addEventListener('input', (e) => {
        let ma_costo_evaluacion = parseFloat(e.target.value) || 0;

        if(evaluacion.checked){
            saldo.value = parseFloat(ma_costo_evaluacion) + parseFloat(ma_costo_curso.value);
        }
    })

    function calcularSaldo(importe) {
        let saldoTotal = 0;
        
        if(evaluacion.checked)
        {
            saldoTotal =  parseFloat(ma_costo_evaluacion.value) + parseFloat(ma_costo_curso.value);
        }
        else
        {
            saldoTotal =  parseFloat(ma_costo_curso.value);
        }

        if(importe > saldoTotal){
            importe = saldoTotal;
            e.target.value = importe;
        }

        if(evaluacion.checked){
            saldo.value = saldoTotal - importe;
        }
        else{
            saldo.value = parseFloat(ma_costo_curso.value) - importe;
        }
    }

    $('#form').submit(function (event) {
        event.preventDefault();
        let saldo = 0;
        if(evaluacion.value == 1){
            saldo = parseFloat(ma_costo_evaluacion.value) + parseFloat(ma_costo_curso.value);
        }
        else {
            saldo = parseFloat(ma_costo_curso.value);
        }
        var data = {
            estudiante: $('#estudiante').val(),
            curso: $('#curso').val(),
            es_codigo: $('#es_codigo').val(),
            cu_codigo: $('#cu_codigo').val(),
            ma_costo_curso: $('#ma_costo_curso').val(),
            ma_costo_evaluacion: $('#ma_costo_evaluacion').val(),
            ma_duracion: $('#ma_duracion').val(),
            salida: $('#salida').val(),
            am_codigo: $('#am_codigo').val(),
            se_codigo: $('#se_codigo').val(),
            ma_categoria: $('#ma_categoria').val(),
            ma_evaluacion: evaluacion.value,
            importe: $('#importe').val(),
            pagado: $('#pagado').is(':checked'),
            saldo: $('#saldo').val(),
            saldoTotal: saldo,
            detalle_recojo: $('#detalle_recojo').val()
        };

        //console.log(data);
        $.ajax({
            type: 'POST',
            url: BASEURL + '/manager_matricula/',
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
                    console.log(matricula);
                    $('#successModal').modal('show');
                
                    $('#pdfA4').attr('href', `${URLPDF}matricula/${matricula.ma_codigo}/${user.us_codigo}/A4`);
                    $('#pdfTicket').attr('href', `${URLPDF}matricula/${matricula.ma_codigo}/${user.us_codigo}/ticket`);
    
                    $('#acceptBtn').click(function () {
                        window.location.href = '/manager/horario-matricula/' + response.data.ma_codigo;
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