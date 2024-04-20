$(document).ready(function () {
    $(document).on('click', '.descargar-pdf', function () {
        const URLBASE = '/autoescuela/public/api/kardex-pdf/';
        const TOKEN = localStorage.getItem('token');
        //e.preventDefault();

        // ID de la matrícula que quieres descargar como PDF
        var matriculaId = $(this).data('codigo'); // Aquí deberías obtener dinámicamente el ID de la matrícula
        console.log(matriculaId);
        // Hacer la petición AJAX
        $.ajax({
            url: URLBASE + matriculaId,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + TOKEN // Asegúrate de reemplazar 'tuTokenDeAutorizacion' con el token real
            },
            data: {
                matricula_id: matriculaId
            },
            success: function (response) {
                console.log(response);
                if (response) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'kardex.pdf';
                    link.click();
                } else {
                    alert("Error al generar el archivo PDF.");
                }
                // Manejar la respuesta exitosa (el PDF)
                /*var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'kardex.pdf';
                link.click();*/
            },
            error: function (xhr, status, error) {
                // Manejar errores de la petición AJAX
                console.error(xhr.responseText);
            }
        });
    });
});
