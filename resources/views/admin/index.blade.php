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
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ingresos por Mes</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div id="loadingSpinner" class="loading"></div>
                        <canvas id="ingresosChart" style="display:none;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Movimientos del Mes</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <div id="loadingSpinnerPie" class="loading"></div>
                        <canvas id="myPieChart" style="display:none;"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: rgba(54, 162, 235, 0.5);"></i> Ingresos
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: rgba(255, 99, 132, 0.5)"></i> Egresos
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/admin/charts/grafico-barras.js') }}"></script>
    <script src="{{ asset('js/admin/charts/grafico-pastel.js') }}"></script>
@endsection
