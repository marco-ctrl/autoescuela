$(document).ready(function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const BASEURL = window.apiUrl + "/api";
    const URLPDF = window.apiUrl + "/api/pdf";
    const token = localStorage.getItem("token");

    $('#usuario').val(user.us_codigo);
    var estudiantes = [];

    $("#btn-filtrar").click(function (e) {
        e.preventDefault();
        ListarEstudiantes($("#fecha").val());
    });

    function ListarEstudiantes(fecha) {
        $.ajax({
            type: "POST",
            url: BASEURL + "/docente_horario/reporte-general",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token,
            },
            data: {
                fecha: fecha,
                codigo: user.us_codigo,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                estudiantes = response.data;
                $('#datos').val(JSON.stringify(response.data));
                $("#titulo-table").append(response.data[0].titulo);
                $("#generalTable tbody").empty(); // Limpiar la tabla antes de cargar nuevos datos
                $.each(response.data, function (index, matricula) {
                    $("#generalTable tbody").append(
                        cargarTablaMatricula(matricula)
                    );
                });
            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
    }

    function cargarTablaMatricula(matricula) {
        let observacion =
            matricula.observacion == null ? "" : matricula.observacion;

        let html = `<tr>
                        <td>${matricula.hora}</td>
                        <td>${matricula.matricula}</td>
                        <td class="${matricula.textColor}">${matricula.saldo}</td>                       
                        <td>${matricula.sede}</td>
                        <td>${matricula.ci}</td>
                        <td>${matricula.estudiante}</td>
                        <td>${matricula.categoria}</td>
                        <td>${matricula.curso}</td>
                        <td>${matricula.numero}</td>
                        <td>${observacion}</td>
                        <td>${matricula.firma}</td>
                    </tr>`;
        return html;
    }

    /*$("#btn-pdf").click(function (e) {
        generarPDF();
    });*/

    function generarPDF() {
        //console.log(estudiantes);
        $.ajax({
            type: "GET",
            url: URLPDF + "/docente/reporte-general",
            headers: {
                Accept: "application/pdf",
                Authorization: "Bearer " + token,
            },
            data: {
                datos: estudiantes,
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            complete: function () {
                $("#overlay").hide();
            },
            success: function (response) {
                $("#overlay").hide();
                // Crear un objeto Blob a partir de la respuesta
                var blob = new Blob([response], { type: 'application/pdf' });
                // Crear una URL para el Blob
                var blobURL = URL.createObjectURL(blob);
                // Abrir el PDF en una nueva ventana
                window.open(blobURL);
            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.error(xhr.responseJSON.message); // Manejar el error si la solicitud falla
            },
        });
        
    }
});
