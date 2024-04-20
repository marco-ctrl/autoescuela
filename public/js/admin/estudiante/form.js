$(document).ready(function () {
    const TOKEN = localStorage.getItem('token');
    const BASEURL = '/autoescuela/public/api';

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
                'Authorization': 'Bearer ' + TOKEN // Pasar el token como parte de la cabecera de autorización
            },
            data: estudiante,
            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (response) {
                $('#overlay').hide();
                if (response.status) {
                    Apagar();
                    $('#successModal').modal('show');
                    $('#acceptBtn').click(function () {
                        window.location.href = '/autoescuela/public/admin/estudiante';
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
});