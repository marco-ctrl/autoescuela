document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = window.apiUrl;
    const usuario = JSON.parse(localStorage.getItem("user"));

    const token = localStorage.getItem("token");
    
    listarCards();

    function listarCards() {
        let us_codigo = usuario.us_codigo;
        $.ajax({
            type: "GET",
            url: baseUrl + "/api/docente_home/" + us_codigo,
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
                    let cardsContainer = document.getElementById("cards");
                    response.data.forEach(function (item) {
                        cardsContainer.innerHTML += cardsRender(item);
                    });
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

    const cardsRender = (cards) => {
        return `
        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-${cards.color} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            ${cards.title}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${cards.value}</div>
                    </div>
                    <div class="col-auto">
                        <i class="${cards.icon} fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
        `;
    };

    $.ajax({
        type: "GET",
        url: baseUrl + '/api/docente_horario/cantidad-clases-mes/' + usuario.us_codigo,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        beforeSend: function() {
            $('#overlay').show();
        },
        success: function(response) {
            const meses = response.data.map(dato => {
                const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                    'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
                    'Noviembre', 'Diciembre'
                ];

                // Obtener el nombre del mes correspondiente al número del mes
                const nombreMes = nombresMeses[dato.mes - 1];
                return nombreMes;
            });

            const ingresos = response.data.map(dato => {
                return dato.total;
            });

            var ctx = document.getElementById('ingresosChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Cantidad de Clases por Mes',
                        data: ingresos,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(error, xhr) {
            console.error(error);
        }
    });
});
