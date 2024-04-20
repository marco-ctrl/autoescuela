document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    const baseUrl = '/autoescuela/public/api/estudiante_horario';
    const usuario = JSON.parse(localStorage.getItem('user'));
    
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
        eventClick: function (info) {
            if (info.event.extendedProps.asistencia == 1) {
                $('#asistencia').prop('checked', true);
                $('#justificacion').prop('disabled', true);
            } else {
                $('#asistencia').prop('checked', false);
                $('#justificacion').prop('disabled', false);
            }
            // Mostrar modal con detalles del evento
            $('#estudiante').val(info.event.extendedProps.estudiante);
            $('#curso').val(info.event.extendedProps.curso);
            $('#codigo').val(info.event.id);
            $('#observacion').val(info.event.extendedProps.observacion);
            $('#modalAsistencia').modal('show');
        },
        selectConstraint: "businessHours", // Restringe la selección a las horas hábiles
        businessHours: { // Define las horas hábiles
            startTime: '06:00', // Hora de inicio
            endTime: '20:00', // Hora de fin
        },


    });
    calendar.render(); // Renderiza el calendario
    calendar.gotoDate(new Date());

    function listarHorarios() {
        let us_codigo = usuario.us_codigo;
        $.ajax({
            type: 'GET',
            url: baseUrl + '/estudiante/' + us_codigo,
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
                    horasClases = response.data;
                    agregarEventos(eventos);
                    eventos = [];
                }
                else {
                    console.log(response.message);
                }
            },
            error: function (xhr) {
                console.error('Error al enviar datos:', xhr.responseJSON);
            }
        });
    }

    
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
                estudiante: evento.estudiante,
                curso: evento.curso,
                observacion: evento.observacion,
                asistencia: evento.asistencia,
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

    function eventoYaExiste(evento) {
        return eventos.some(e => e.id === evento.id && e.start === evento.start && e.end === evento.end);
    }
});