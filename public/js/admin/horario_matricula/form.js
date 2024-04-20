document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    const baseUrl = '/autoescuela/public/api';

    var horasClases = [];
    var horasOcupadas = [];
    var eventos = [];


    listarHorarios();

    var calendarEl = document.getElementById('calendario');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'timeGridWeek',
        allDaySlot: false,
        slotMinTime: '06:00:00',
        slotMaxTime: '20:00:00',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridDay,timeGridWeek'
        },
        /*validRange: {
            start: new Date(), // Puedes ajustar esto según tu necesidad
            end: '2100-01-01' // Esto es solo para asegurarse de que no haya un final
        },*/
        dateClick: function (info) {
            let fechaFormateada = moment(info.date).format("YYYY-MM-DD HH:mm:ss");
            agregarHorario(fechaFormateada);
        },
        eventClick: function (info) {
            // Mostrar modal con detalles del evento
            $('#modalTitulo').text(info.event.title);
            $('#modalInicio').text('Inicio: ' + moment(info.event.start).format("YYYY-MM-DD HH:mm:ss"));
            $('#modalFin').text('Fin: ' + moment(info.event.end).format("YYYY-MM-DD HH:mm:ss"));
            $('#modalDocente').text('Docente: ' + info.event.extendedProps.docente);
            $('#modalDetalles').modal();
        },
        selectConstraint: "businessHours", // Restringe la selección a las horas hábiles
        businessHours: { // Define las horas hábiles
            startTime: '06:00', // Hora de inicio
            endTime: '20:00', // Hora de fin
        },


    });
    calendar.render(); // Renderiza el calendario
    calendar.gotoDate(new Date());

    function agregarHorario(fechaInicio) {
        var data = {
            docente: $('#docente').val(),
            do_codigo: $('#do_codigo').val(),
            ma_codigo: $('#ma_codigo').val(),
            hm_fecha_inicio: fechaInicio,
            hm_color: $('#hm_color').val(),
        }

        $.ajax({
            type: 'POST',
            url: baseUrl + '/admin_horario/store',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            data: data,
            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (response) {
                $('#overlay').hide();
                if (response.status) {
                    listarHorarios();
                }
                else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(response.message);
                }
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

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
        });
    }

    function listarHorarios() {
        ma_codigo = $('#ma_codigo').val();
        $.ajax({
            type: 'GET',
            url: baseUrl + '/admin_horario/matricula/' + ma_codigo,
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            beforeSend: function () {
                $('#overlay').show();
            },
            complete: function () {
                $('#overlay').hide();
            },
            success: function (response) {
                if (response.status) {
                    var tbody = document.getElementById('horarios');

                    tbody.innerHTML = '';

                    response.data.forEach(function (item) {
                        var row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${item.fecha}</td>
                            <td>${item.hora_inicio}</td>
                            <td>${item.hora_final}</td>
                            <td>${item.docente}</td>
                            <td><button type="button" class="btn btn-danger eliminar" 
                                data-codigo="${item.id}"
                                title="Quitar Horario">
                                <i class="fas fa-trash-alt "></i>
                                </button>
                            </td>`;

                        tbody.appendChild(row);

                    });
                    horasClases = response.data;
                    
                    agregarEventos(eventos);
                    eventos = [];
                }
                else {
                    console.log(response.message);
                }
            },
            error: function (xhr) {
                $('#loader').hide();
                console.error('Error al enviar datos:', xhr.responseJSON);
            }
        });
    }

    function listarHorariosDocente(do_codigo) {
        $.ajax({
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            beforeSend: function () {
                $('#overlay').show();
            },
            complete: function () {
                $('#overlay').hide();
            },
            url: baseUrl + '/admin_horario/docente/' + do_codigo,
            success: function (response) {
                horasOcupadas = response.data;
                agregarEventos(eventos);
            },
            error: function (xhr) {
                $('#loader').hide();
                console.error('Error al enviar datos:', xhr.responseJSON);
            }
        });
    }

    $(document).on('click', '.eliminar', function () {
        var codigoHorario = $(this).data('codigo');

        if (confirm('¿Estás seguro de que deseas eliminar este horario?')) {
            $.ajax({
                url: baseUrl + '/admin_horario/' + codigoHorario,
                type: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                success: function (response) {
                    console.log('Horario eliminado con éxito.');

                    alertify.set('notifier', 'position', 'top-right')
                    alertify.success(response.message);
                    listarHorarios()
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el horario:', xhr.responseJSON);
                }
            });
        }
    });

    function agregarEventos(eventos) {
        horasClases.forEach(evento => {
            if (!eventoYaExiste(evento)) {
                eventos.push(evento);
            }
        });
        
        horasOcupadas.forEach(evento => {
            if (!eventoYaExiste(evento) || evento.title !== 'Ocupado') {
                eventos.push(evento);
            }
        });
        
        calendar.removeAllEvents(eventos);
        eventos.forEach(function (evento) {
            calendar.addEvent({
                id: evento.id,
                title: evento.title,
                start: evento.start,
                end: evento.end,
                backgroundColor: evento.color,
                docente: evento.docente,
                extraOptions: {
                    curso: "MEDIO CURSO 1",
                    estudiante: "SANTOS CONDORI TORREZ",
                    horas: 1
                }
            });

            /*calendar.setOption('eventContent', function(info) {
                // Crear el elemento contenedor del evento
                var container = document.createElement('div');
                container.classList.add('fc-content');
            
                // Crear el elemento para el tiempo del evento
                var timeElement = document.createElement('div');
                timeElement.classList.add('fc-time');
                timeElement.dataset.start = info.event.start;
                timeElement.dataset.full = `${info.event.start} - ${info.event.end}`;
                timeElement.innerHTML = `<span>${info.event.start} - ${info.event.end}</span>`;
                container.appendChild(timeElement);
            
                // Crear el elemento para el título del evento
                var titleElement = document.createElement('div');
                titleElement.classList.add('fc-title');
                titleElement.innerHTML = `
                    ${info.event.extendedProps.curso}<br>
                    ${info.event.extendedProps.estudiante}
                    <p class="bg-success span-horas">${info.event.extendedProps.horas}</p>
                    <p class="${info.event.extendedProps.asistencia === 'Falta' ? 'bg-danger' : 'bg-success'} span-horas" style="left: 0;">
                        ${info.event.extendedProps.asistencia === 'Falta' ? 'F' : 'A'}
                    </p>
                `;
                container.appendChild(titleElement);
            
                return { domNodes: [container] };
            });*/
        });
    }

    $('#docente').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseUrl + '/admin_docente/autocomplete',
                dataType: "json",
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                data: {
                    term: request.term // envía el término de búsqueda al servidor
                },
                success: function (resp) {
                    response(resp.data); // Envía los datos al widget Autocomplete
                }
            });
        },
        select: function (event, ui) {
            $('#do_codigo').val(ui.item.id);
            listarHorariosDocente($('#do_codigo').val());
            eventos = [];
        }
    });

    $(document).on('click', '#btn-ver', function () {
        $('#modalTableHorarios').modal('show');
    });

    function eventoYaExiste(evento) {
        return eventos.some(e => e.id === evento.id && e.start === evento.start && e.end === evento.end);
    }
});