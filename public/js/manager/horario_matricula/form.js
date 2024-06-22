document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem("token");
    const baseUrl = window.apiUrl + "/api";

    var horasClases = [];
    var horasOcupadas = [];
    var eventos = [];

    listarHorarios();

    var calendarEl = document.getElementById("calendario");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "es",
        slotMinTime: "06:00:00",
        slotMaxTime: "20:00:00",
        defaultTimedEventDuration: "01:00:00",
        initialView: "timeGridWeek",
        handleWindowResize: true,
        allDaySlot: false,
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "timeGridDay,timeGridWeek",
        },
        dateClick: function (info) {
            let fechaFormateada = moment(info.date).format(
                "YYYY-MM-DD HH:mm:ss"
            );
            agregarHorario(fechaFormateada);
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
            if(info.event.extendedProps.asistencia !== undefined){
                if (info.event.extendedProps.asistencia == 1) {
                    $('#asistencia').prop('checked', true);
                    $('#justificacion').prop('disabled', true);
                } else {
                    $('#asistencia').prop('checked', false);
                    $('#justificacion').prop('disabled', false);
                }
                // Mostrar modal con detalles del evento
                $('#estudiante').val(info.event.extendedProps.estudiante);
                $('#tema').val(info.event.extendedProps.tema);
                $('#nota').val(info.event.extendedProps.nota);
                $('#curso').val(info.event.extendedProps.curso);
                $('#codigo').val(info.event.id);
                $('#observacion').val(info.event.extendedProps.observacion);
                $('#modalAsistencia').modal('show');
            }
        },
        selectConstraint: "businessHours", // Restringe la selección a las horas hábiles
        businessHours: {
            // Define las horas hábiles
            startTime: "06:00", // Hora de inicio
            endTime: "20:00", // Hora de fin
        },
    });

    calendar.render(); // Renderiza el calendario
    calendar.gotoDate(new Date());

    function agregarHorario(fechaInicio) {
        var data = {
            docente: $("#docente").val(),
            do_codigo: $("#do_codigo").val(),
            ma_codigo: $("#ma_codigo").val(),
            hm_fecha_inicio: fechaInicio,
            hm_color: $("#hm_color").val(),
        };

        $.ajax({
            type: "POST",
            url: baseUrl + "/manager_horario/store",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: data,
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (response) {
                $("#overlay").hide();
                if (response.status) {
                    listarHorarios();
                } else {
                    alertify.set("notifier", "position", "top-right");
                    alertify.error(response.message);
                }
                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();
            },
            error: function (xhr) {
                $("#overlay").hide();
                console.error("Error al enviar datos:", xhr.responseJSON);

                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $.each(xhr.responseJSON.errors, function (key, value) {
                    var inputField = $("#" + key);
                    inputField.addClass("is-invalid");

                    var errorFeedback = $(
                        '<div class="invalid-feedback"></div>'
                    ).text(value[0]); // Asume que quieres mostrar solo el primer mensaje de error
                    inputField.after(errorFeedback);
                });
            },
        });
    }

    function listarHorarios() {
        ma_codigo = $("#ma_codigo").val();
        $.ajax({
            type: "GET",
            url: baseUrl + "/manager_horario/matricula/" + ma_codigo,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                if (response.status) {
                    var tbody = document.getElementById("horarios");

                    tbody.innerHTML = "";

                    response.data.forEach(function (item) {
                        var row = document.createElement("tr");

                        row.innerHTML = `
                            <td>${item.fecha}</td>
                            <td>${item.hora_inicio}</td>
                            <td>${item.hora_final}</td>
                            <td>${item.docente}</td>
                            `;

                        tbody.appendChild(row);
                    });
                    horasClases = response.data;

                    agregarEventos(eventos);
                    eventos = [];
                } else {
                    console.log(response.message);
                }
            },
            error: function (xhr) {
                $("#loader").hide();
                console.error("Error al enviar datos:", xhr.responseJSON);
            },
        });
    }

    function listarHorariosDocente(do_codigo) {
        $.ajax({
            type: "GET",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            url: baseUrl + "/manager_horario/docente/" + do_codigo,
            success: function (response) {
                horasOcupadas = response.data;
                agregarEventos(eventos);
            },
            error: function (xhr) {
                $("#loader").hide();
                console.error("Error al enviar datos:", xhr.responseJSON);
            },
        });
    }

    function agregarEventos(eventos) {
        horasClases.forEach((evento) => {
            if (!eventoYaExiste(evento)) {
                eventos.push(evento);
            }
        });

        horasOcupadas.forEach((evento) => {
            if (!eventoYaExiste(evento) || evento.title !== "Ocupado") {
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
                tema: evento.tema,
                nota: evento.nota,
                comentario: evento.asistencia == 0 ? 'F' :'A',
                bgColor: evento.asistencia == 0 ? 'bg-danger' : 'bg-success',
            });
        });
    }

    $("#docente").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseUrl + "/manager_docente/autocomplete",
                dataType: "json",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    term: request.term, // envía el término de búsqueda al servidor
                },
                success: function (resp) {
                    response(resp.data); // Envía los datos al widget Autocomplete
                },
                error: function (xhr, status, error) {
                    console.error(
                        "Error al obtener los docentes:",
                        xhr.responseJSON
                    );
                }
            });
        },
        select: function (event, ui) {
            $("#do_codigo").val(ui.item.id);
            listarHorariosDocente($("#do_codigo").val());
            eventos = [];
        },
    });

    $(document).on("click", "#btn-ver", function () {
        $("#modalTableHorarios").modal("show");
    });

    function eventoYaExiste(evento) {
        return eventos.some(
            (e) =>
                e.id === evento.id &&
                e.start === evento.start &&
                e.end === evento.end
        );
    }

    $('#btnGuardar').click(function () {
        marcarAsistencia();
    });

    $('#asistencia').change(function() {
        if($(this).is(':checked')) {
            $(this).val(1);
            $('#justificacion').prop('disabled', true);
            $('#justificacion').val('');
        } else {
            $(this).val(0);
            $('#justificacion').prop('disabled', false);
        }
    });

    function marcarAsistencia() {
        var data = {
            tema: $('#tema').val(),
            nota: $('#nota').val(),
            asistencia: $('#asistencia').val(),
            justificacion: $('#justificacion').val(),
            observacion: $('#observacion').val(),
            codigo: $('#codigo').val()
        }
        console.log(data);
        $.ajax({
            type: 'PUT',
            url: baseUrl + `/docente_horario/horario-matricula/${data.codigo}/update`,
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            data: data,
            beforeSend: function () {
                $('#overlay').show();
            },
            complete: function () {
                $('#overlay').hide();
                listarHorarios();
            },
            success: function (response) {
                if (response.status) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.message);
                    $('#modalAsistencia').modal('hide');
                    $('#formHorario')[0].reset();
                }
                else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(response.message);
                }
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

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
    }
});
