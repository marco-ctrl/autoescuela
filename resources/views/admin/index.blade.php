@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    
        <!-- Page Heading -->
        <!--<div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>-->

        <!-- Content Row -->
        <div class="row">
            @foreach ($cards as $card)
                <x-card-component :cards="$card" />
            @endforeach
        </div>
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Ingresos por Mes</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="ingresosChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const token = localStorage.getItem('token');
            const BASEURL = window.apiUrl;

            $.ajax({
                type: "GET",
                url: BASEURL + '/api/admin_pago',
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
                                label: 'Ingresos por Mes',
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
                }
            });
        });
    </script>
@endsection
