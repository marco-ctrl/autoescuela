@extends('docente.layouts.app')
@section('title', 'Autoescuela')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Reporte General</h6>
    </div>
    <div class="card-body">
        <div class="row pb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <label for="fecha">Fecha *</label>
                    <input type="date" id="fecha" class="form-control" value="{{ date('Y-m-d') }}">
                    <button class="btn btn-outline-primary" type="button" id="btn-filtrar"><i class="fas fa-eye"></i> Mostrar</button>
                    
                    <form method="POST" action="{{ route('docente.pdf.reporte-general') }}" target="_blank">
                        <input type="hidden" id="usuario" name="usuario" />
                        <input type="hidden" id="datos" name="datos" />
                        <button class="btn btn-outline-danger" type="submit" id="btn-pdf"><i class="far fa-file-pdf"></i> Exportar PDF</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm text-center" id="generalTable" width="100%"
                cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="11" id="titulo-table"></th>
                    </tr>
                    <tr>
                        <th>HORA</th>
                        <th>MATRICULA</th>
                        <th>SALDO BS.</th>
                        <th>CC</th>
                        <th>CI</th>
                        <th>ESTUDIANTE</th>
                        <th>CAT</th>
                        <th>CURSO</th>
                        <th>NRO</th>
                        <th>OBSERVACIONES</th>
                        <th>FIRMA</th>
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
<script src="{{ asset('js/docente/reportes/reporteGeneral.js') }}"></script>
@endsection