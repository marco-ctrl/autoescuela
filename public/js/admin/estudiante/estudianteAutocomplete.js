$(document).ready(function () {
    const BASEURL = '/autoescuela/public/api';
    const token = localStorage.getItem('token');

    $('.estudiante').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASEURL + '/admin_estudiante/autocomplete',
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
            console.log(ui.item.id);
            getEstudiante(ui.item.id);
            $('#btn-siguiente').show();
            $('#btn-guardar').hide();
        }
    });

    $('#btn-siguiente').on('click', function () {
        cursoFocus();
    });

    function cursoFocus(){
        setTimeout(function() {
            $('#curso').focus();
        }, 100);
    }

    function getEstudiante(id) {
        $.ajax({
            url: BASEURL + '/admin_estudiante/' + id + '/show',
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token // Pasar el token como parte de la cabecera de autorización
            },
            success: function (response) {
                if (response.status) {
                    estudiante = response.data;
                    $('#es_codigo').val(estudiante.id);
                    $('#es_documento').val(estudiante.documento);
                    $('#es_expedicion').val(estudiante.expedicion);
                    $('#es_tipodocumento').val(estudiante.tipo_documento);
                    $('#es_nacimiento').val(estudiante.fecha_nacimiento);
                    $('#es_nombre').val(estudiante.nombre);
                    $('#es_apellido').val(estudiante.apellido);
                    $('#es_direccion').val(estudiante.direccion);
                    $('#es_celular').val(estudiante.celular);
                    $('#es_observacion').val(estudiante.observacion);
                    $('#es_correo').val(estudiante.correo);
                    if (estudiante.genero == 1) {
                        document.getElementById('masculino').checked = true;
                    } else {
                        document.getElementById('femenino').checked = true;
                    }
                    $('#es_foto').val(estudiante.foto);
                    $('#imagen').attr('src', estudiante.foto);
                }

            },
            error: function (xhr, status, error) {
                console.log(error);

            }
        });

    }

    var es_documento = document.getElementById('es_documento');
    var es_expedicion = document.getElementById('es_expedicion');
    var es_tipodocumento = document.getElementById('es_tipodocumento');
    var es_nombre = document.getElementById('es_nombre');
    var es_apellido = document.getElementById('es_apellido');
    var es_nacimiento = document.getElementById('es_nacimiento');
    var es_direccion = document.getElementById('es_direccion');
    var es_telefono = document.getElementById('es_celular');
    var es_correo = document.getElementById('es_correo');
    var es_observacion = document.getElementById('es_observacion');
    var es_foto = document.getElementById('es_foto');

    $('#formEstudiante').submit(function (e) {
        e.preventDefault();
        agregarEstudiante();
    });

    function agregarEstudiante() {
        //console.log(es_documento.value);
        let es_genero = document.querySelector('input[name="es_genero"]:checked');
        var estudiante = {
            es_documento: es_documento.value,
            es_expedicion: es_expedicion.value,
            es_tipodocumento: es_tipodocumento.value,
            es_nombre: es_nombre.value,
            es_apellido: es_apellido.value,
            es_nacimiento: es_nacimiento.value,
            es_genero: es_genero.value,
            es_direccion: es_direccion.value,
            es_celular: es_telefono.value,
            es_correo: es_correo.value,
            es_observacion: es_observacion.value,
            es_foto: es_foto.value
        };
        //console.log(estudiante);
        $.ajax({
            type: 'POST',
            url: BASEURL + '/admin_estudiante',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token // Pasar el token como parte de la cabecera de autorización
            },
            data: estudiante,
            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (response) {
                $('#overlay').hide();
                if (response.status) {
                    Apagar();
                    let estudiante = response.data;

                    $('#es_codigo').val(estudiante.id);
                    $('#estudiante').val(estudiante.documento + ' - ' + estudiante.nombre + ' ' + estudiante.apellido);
                    $('#successModal').modal('show');
                    
                    $('#acceptBtn').click(function () {
                        $('#modalRegistrarEstudiante').modal('hide');
                        cursoFocus();
                    });
                }
            },
            error: function (xhr) {
                $('#overlay').hide();
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
    }

    $('#es_documento').on('input', function() {
        // Verifica si el campo de autocompletado tiene algún valor
        if ($(this).val().trim() == '') {
            $('#es_codigo').val('');
            $('#formEstudiante').trigger('reset');
        }
        
        if($('#es_codigo').val() != ''){
            console.log($('#es_codigo').val());
            $('#btn-siguiente').show();
            $('#btn-guardar').hide();
        }
        else{
            $('#btn-siguiente').hide();
            $('#btn-guardar').show();
        }
    });

    function Apagar() {
        stream = video.srcObject;
        if (stream != null) {
            tracks = stream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });
            video.srcObject = null;
            video.setAttribute('poster', "/autoescuela/public/img/user-default.png");
        }
    }

    /*$('body').on('focus', '#es_documento', function () {
        console.log('Modal abierto');
        
        $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: BASEURL + '/admin_estudiante/autocomplete',
                    dataType: "json",
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token // Pasar el token como parte de la cabecera de autorización
                    },
                    data: {
                        term: request.term // envía el término de búsqueda al servidor
                    },
                    success: function(resp) {
                        response(resp.data); // Envía los datos al widget Autocomplete
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            },
            select: function(event, ui) {
                $('#es_codigo').val(ui.item.id);
                console.log(ui.item.id);
            }
        });
    });*/

});