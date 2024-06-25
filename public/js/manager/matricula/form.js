$(document).ready(function () {
    $('#modalRegistrarEstudiante').modal('show');

    var token = localStorage.getItem('token');
    const BASEURL = window.apiUrl + '/api';
    const URLPDF = window.apiUrl + '/api/pdf/';
    const user = JSON.parse(localStorage.getItem('user'));
    
    console.log(user.us_codigo);

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
            url: BASEURL + "/manager_curso/" + cu_codigo,
            type: "get",
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status) {
                    ma_costo_curso.value = response.data.cu_costo;
                    ma_costo_evaluacion.value =
                        response.data.cu_costo_evaluacion;

                    ma_duracion.value = response.data.cu_duracion;

                    importe.disabled = false;
                    importe.value = 0;

                    let costoCurso = parseFloat(ma_costo_curso.value) || 0;
                    let costoEvaluacion =
                        parseFloat(ma_costo_evaluacion.value) || 0;

                    saldo.value = calcularSaldo(costoCurso, costoEvaluacion);
                    pagado.disabled = false;
                    ma_duracion.disabled = false;
                    ma_costo_curso.disabled = false;
                } else {
                    console.error(response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(
                    "Error al cargar los datos: ",
                    textStatus,
                    errorThrown
                );
            },
        });
    }

   pagado.addEventListener("change", (e) => {
        let costoCurso = parseFloat(ma_costo_curso.value) || 0;
        let costoEvaluacion = parseFloat(ma_costo_evaluacion.value) || 0;

        if (e.target.checked) {
            importe.value = costoCurso + costoEvaluacion;
            importe.disabled = true;
            saldo.value = "0";
            pagado.value = true;
        } else {
            importe.disabled = false;
            saldo.value = costoCurso + costoEvaluacion;
            importe.value = "0";
            pagado.value = false;
        }
    });

    evaluacion.addEventListener("change", (e) => {
        let costoCurso = parseFloat(ma_costo_curso.value) || 0;
        let costoEvaluacion = parseFloat(ma_costo_evaluacion.value) || 0;
        let importeCalcular = parseFloat(importe.value) || 0;
        let costoTotal = calcularSaldo(costoCurso, costoEvaluacion);
        saldo.value = costoTotal - importeCalcular;

        if (e.target.checked) {
            ma_costo_evaluacion.disabled = false;
            if (importe.disabled) {
                importe.disabled = false;
            }
            if (pagado.disabled) {
                pagado.disabled = false;
            }
        } else {
            ma_costo_evaluacion.disabled = true;
        }
    });

    importe.addEventListener("input", (e) => {
        let importe = parseFloat(e.target.value) || 0;
        let costoCurso = parseFloat(ma_costo_curso.value) || 0;
        let costoEvaluacion = parseFloat(ma_costo_evaluacion.value) || 0;

        let costoTotal = calcularSaldo(costoCurso, costoEvaluacion);

        if (importe > costoTotal) {
            importe = costoTotal;
            e.target.value = importe;
            saldo.value = 0;
        } else {
            importe = e.target.value;
            saldo.value = costoTotal - importe;
        }
    });

   ma_costo_curso.addEventListener("input", (e) => {
        let costoCurso = parseFloat(e.target.value) || 0;
        let costoEvaluacion = parseFloat(ma_costo_evaluacion.value) || 0;

        saldo.value = calcularSaldo(costoCurso, costoEvaluacion);
    });

    ma_costo_evaluacion.addEventListener("input", (e) => {
        let costoEvaluacion = parseFloat(e.target.value) || 0;
        let costoCurso = parseFloat(ma_costo_curso.value) || 0;

        saldo.value = calcularSaldo(costoCurso, costoEvaluacion);
    });

    function calcularSaldo(costoCurso, costoEvaluacion) {
        let costoTotal = 0;
        if (evaluacion.checked) {
            if ($("#curso").val() != "") {
                costoTotal = costoCurso + costoEvaluacion;
            } else {
                costoTotal = costoEvaluacion;
            }
        } else {
            if ($("#curso").val() != "") {
                costoTotal = costoCurso;
            } else {
                costoTotal = 0;
            }
        }

        return costoTotal;
    }
    
    $("#curso").on("input", function () {
        if ($("#curso").val() == "") {
            ma_costo_curso.value = "";
            ma_duracion.value = "";
            importe.value = "";

            ma_costo_curso.disabled = true;
            ma_duracion.disabled = true;

            let costoEvaluacion = parseFloat(ma_costo_evaluacion.value) || 0;

            saldo.value = calcularSaldo(0, costoEvaluacion);
        }
    });

    $("#form").submit(function (event) {
        event.preventDefault();
        if (evaluacion.checked) {
            evaluacion.value = 1;
        } else {
            evaluacion.value = 0;
        }
        if (evaluacion.value == 0 && $("#curso").val() == "") {
            alertify.set("notifier", "position", "top-right");
            alertify.error(
                "Debe seleccionar un curso o evaluacion para poder registrar la matr��cula"
            );
        } else {
            var data = {
                estudiante: $("#estudiante").val(),
                curso: $("#curso").val(),
                es_codigo: $("#es_codigo").val(),
                cu_codigo: $("#cu_codigo").val(),
                ma_costo_curso: $("#ma_costo_curso").val(),
                ma_costo_evaluacion: $("#ma_costo_evaluacion").val(),
                ma_duracion: $("#ma_duracion").val(),
                salida: $("#salida").val(),
                am_codigo: $("#am_codigo").val(),
                se_codigo: $("#se_codigo").val(),
                ma_categoria: $("#ma_categoria").val(),
                ma_evaluacion: evaluacion.value,
                importe: $("#importe").val(),
                pagado: $("#pagado").is(":checked"),
                saldo: saldo.value,
                saldoTotal: saldo.value,
                detalle_recojo: $("#detalle_recojo").val(),
            };

            //console.log(data);
            $.ajax({
                type: "POST",
                url: BASEURL + "/manager_matricula/store",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorizaci��n
                },
                data: data,
                beforeSend: function () {
                    $("#overlay").show();
                },
                complete: function () {
                    $("#overlay").hide();
                },
                success: function (response) {
                    if (response.status) {
                        let matricula = response.data;
                        console.log(matricula);
                        $("#successModal").modal("show");

                        $("#pdfA4").attr(
                            "href",
                            `${URLPDF}matricula/${matricula.ma_codigo}/${user.us_codigo}/A4`
                        );
                        $("#pdfTicket").attr(
                            "href",
                            `${URLPDF}matricula/${matricula.ma_codigo}/${user.us_codigo}/ticket`
                        );

                        let url = "";

                        if (matricula.cu_codigo == null) {
                            url = "/public/manager/matricula/";
                            $("#acceptBtn").html(
                                '<i class="fas fa-check-circle"></i> Aceptar'
                            );
                        } else {
                            url =
                                "/public/manager/horario-matricula/" +
                                response.data.ma_codigo;
                            $("#acceptBtn").html(
                                '<i class="fas fa-calendar-plus"></i> Asignar Horario'
                            );
                        }
                        
                        console.log(url);

                        $("#acceptBtn").click(function () {
                            window.location.href = url;
                        });
                    } else {
                        alertify.set("notifier", "position", "top-right");
                        alertify.error(response.message);
                    }
                },
                error: function (xhr) {
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
    });
});