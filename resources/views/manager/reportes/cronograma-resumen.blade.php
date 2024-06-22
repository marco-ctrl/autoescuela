@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cronograma Resumen</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <form id="form" class="form-inline" method="POST" action="{{ route('manager.pdf.cronograma-resumen') }}" target="_blank">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="fecha">Fecha Incial </label>
                            <input type="date" id="fechaInicial" name="fechaInicial" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="fecha">Fecha Final </label>
                            <input type="date" id="fechaFinal" name="fechaFinal" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <input type="hidden" id="usuario" name="usuario">
                        <button class="btn btn-primary mb-2" type="button" id="btn-filtrar" title="Filtrar"><i
                                class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-danger mb-2" type="submit" id="btn-pdf" title="Generar PDF">
                            <i class="far fa-file-pdf"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-small text-center" 
                    id="resumenTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>ASISTENCIA</th>
                            <th>HORA INICIO</th>
                            <th>HORA FINAL</th>
                            <th>CLASE</th>
                            <th>CURSO</th>
                            <th>DIA</th>
                            <th>ESTUDIANTE</th>
                            <th>INSTRUCTOR</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/manager/reportes/cronogramaResumen.js') }}"></script>
@endsection
