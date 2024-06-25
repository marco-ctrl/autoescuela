$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf/";

    var codigoServicio = 0;

    const token = localStorage.getItem("token");

    loadServicios(1, ""); // Cargar la primera página al cargar la página

    let timeout = null;

    $("#buscarServicio").on("keyup", function () {
        if (timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            let term = $("#buscarServicio").val();
            loadServicios(1, term);
        }, 2000);
    });

    $("#btnBuscarServicio").click(function () {
        let term = $("#buscarServicio").val();
        loadServicios(1, term);
    });

    // Función para cargar los datos de las citas
    function loadServicios(page, term) {
        $.ajax({
            type: "GET",
            url: BASEURL + "/manager_servicios/servicios?term=" + term,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                cargandoDatos();
            },
            success: function (response) {
                let data = response.data;
                $("#servicioTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                let count = 1;
                $.each(data, function (index, servicio) {
                    // Agregar fila a la tabla con los datos de la cita
                    $("#servicioTable tbody").append(
                        cargarTablaMatricula(servicio, count)
                    );

                    count++;
                });

            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
    }

    function cargarTablaMatricula(servicio, count) {
        let estado = servicio.sv_estado == 1 ? "Activo" : "Inactivo";
        let color = servicio.sv_estado == 1 ? "success" : "danger";

        let html = `<tr>
                        <td>${count}</td>
                        <td>${servicio.sv_descripcion}</td>
                        <td>${servicio.sv_precio}</td>
                        <td class="text-${color}">${estado}</td>
                    </tr>`;
        return html;
    }

    function cargandoDatos() {
        $("#servicioTable tbody").empty();
        $("#servicioTable tbody").append(
            `<tr class="spinner-row">
                    <td colspan="4" align="center">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </div>
                    </td>
                </tr>`
        );
    }

    $("#btnGuardar").click(function (e) {
        let data = {
            descripcion: $("#descripcion").val(),
            precio: $("#precio").val(),
        };

        let metodo = codigoServicio == 0 ? "POST" : "PUT";
        let url = codigoServicio == 0 ? "/manager_servicios/servicios" : "/manager_servicios/servicios/" + codigoServicio;

        $.ajax({
            type: metodo,
            url:
                BASEURL + url,
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
            },
            data: data,
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
                codigoServicio = 0;
            },
            success: function (response) {
                $("#modalServicio").modal("hide");

                if (response.status) {
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.message);
                    $("#formServicios").trigger("reset");
                    loadServicios(1, '');
                } else {
                    alertify.set("notifier", "position", "top-right");
                    alertify.error(response.message);
                }

                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();
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
    });


    $("#btnAgregar").click(function () {
        $("#modalServicioTitle").html('Agregar Servicio')
        $("#formServicios").trigger("reset");
        $("#modalServicio").modal("show");
    });
});
