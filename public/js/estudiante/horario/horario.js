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
        eventContent: function (arg) {
            let estudiante = arg.event.extendedProps.estudiante
            if (estudiante === undefined) {
                return {
                    html: `<div class="fc-content" id="event-${arg.event.id}">
                        <div class="fc-time">
                          <span>${arg.timeText}</span>
                        </div>
                        <div class="fc-title-ocupado">Ocupado</div>
                      </div>`,
                };
            } else {
                return {
                    html: `<div class="fc-content" id="event-${arg.event.id}">
                        <div class="fc-time">
                          <span class="bg-success span-horas">${arg.event.extendedProps.numero}</span>
                          <span>${arg.timeText}</span>
                          <span class="${arg.event.extendedProps.bgColor} span-horas" style="left: 0;">${arg.event.extendedProps.comentario}</span>
                        </div>
                        <div class="fc-title">
                        ${arg.event.extendedProps.curso} <br> ${arg.event.extendedProps.estudiante} 
                        </div>
                      </div>`,
                };
            }
            
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
                asistencia: evento.asistencia,
                bgColor: evento.bgColor,
                numero: evento.numero,
                estudiante: evento.estudiante,
                curso: evento.curso,
                comentario: evento.asistencia == 0 ? 'F' :'A',
                bgColor: evento.asistencia == 0 ? 'bg-danger' : 'bg-success',
            });
});
    }

    function eventoYaExiste(evento) {
        return eventos.some(e => e.id === evento.id && e.start === evento.start && e.end === evento.end);
    }
});