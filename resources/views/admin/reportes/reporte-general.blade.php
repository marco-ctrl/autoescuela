@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reporte General</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="docente">Docente</label>
                            <input class="form-control" id="docente" name="docente" placeholder="Buscar Docente...">
                            <input type="hidden" id="do_codigo" name="do_codigo">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="fecha">Fecha* </label>
                            <input type="date" id="fecha" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <button class="btn btn-primary mb-2" type="button" 
                        id="btn-filtrar" title="Filtrar"><i
                                class="fas fa-eye"></i>
                        </button>
                    </form>
                </div>
                <div class="p-2 bd-highlight">
                    <form method="POST" action="{{ route('docente.pdf.reporte-general') }}" target="_blank">
                        <input type="hidden" id="usuario" name="usuario" />
                        <input type="hidden" id="datos" name="datos" />
                        <button class="btn btn-danger" type="submit" id="btn-pdf" title="Generar PDF">
                            <i class="far fa-file-pdf"></i>
                    </button>
                    </form>
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
    <script src="{{ asset('js/admin/reportes/reporteGeneral.js') }}"></script>
@endsection
