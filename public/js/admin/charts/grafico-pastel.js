/*const data = {
    labels: [
        'Ingresos',
        'Egresos'
    ],
    datasets: [{
        data: [3000, 1500], // Datos de ingresos y egresos
        backgroundColor: [
            'rgba(54, 162, 235, 0.2)', // Color para ingresos
            'rgba(255, 99, 132, 0.2)' // Color para egresos
        ],
        borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
    }]
};*/

(Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

// Configuración del gráfico
document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem("token");
    const BASEURL = window.apiUrl;

    const loadingSpinner = document.getElementById('loadingSpinnerPie');
    const canvas = document.getElementById('myPieChart');

    $.ajax({
        type: "GET",
        url: BASEURL + "/api/admin_pago/chart-pie",
        headers: {
            Accept: "application/json",
            Authorization: "Bearer " + token,
        },
        beforeSend: function () {
            loadingSpinner.style.display = "block";
            canvas.style.display = "none";
        },
        complete: function () {
            loadingSpinner.style.display = "none";
            canvas.style.display = "block";
        },
        success: function (response) {
            $("#overlay").hide();
            if (response.status) {
                console.log(response.data);
                const data = {
                    labels: ["Ingresos", "Egresos"],
                    datasets: [
                        {
                            data: [
                                response.data.ingresos,
                                response.data.egresos,
                            ], // Datos obtenidos del backend
                            backgroundColor: [
                                "rgba(54, 162, 235, 0.2)", // Color para ingresos
                                "rgba(255, 99, 132, 0.2)", // Color para egresos
                            ],
                            borderColor: [
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 99, 132, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                };
                const config = {
                    type: "pie",
                    data: data,
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            //backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#ffffff",
                            borderColor: "#dddfeb",
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem
                                            .datasetIndex].label || '';
                                        return datasetLabel + ': Bs.' + number_format(
                                            tooltipItem.yLabel);
                                    }
                                }
                            },
                        },
                        legend: {
                            display: false,
                        },
                        //cutoutPercentage: 80,
                    },
                    /*options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: "top",
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        const label = tooltipItem.label || "";
                                        const value = tooltipItem.raw;
                                        return `${label}: $${value}`;
                                    },
                                },
                            },
                        },
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },*/
                };
                var ctx = document.getElementById("myPieChart");
                var myPieChart = new Chart(ctx, config);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        },
    });
});
