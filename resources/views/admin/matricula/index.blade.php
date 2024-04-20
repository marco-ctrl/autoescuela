@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Matriculados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-small" id="matriculaTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>FOTO</th>
                            <th>NRO KARDEX</th>
                            <th>FECHA DE INSCRIPCION</th>
                            <th>DOCUMENTO CI</th>
                            <th>EXPEDICION</th>
                            <th>NOMBRES</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>USUARIO</th>
                            <th>CATEGORIA</th>
                            <th>SEDE</th>
                            <th>CURSO</th>
                            <th>COSTO</th>
                            <th>CANCELADO</th>
                            <th>SALDO</th>
                            <th>FECHA INICIO</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
        <nav>
            <ul id="paginationContainer" class="pagination justify-content-center flex-wrap">
                <!-- La paginación se mostrará aquí -->
            </ul>
        </nav>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/matricula/lista.js') }}"></script>
    <script src="{{ asset('js/admin/matricula/descargarPdf.js') }}"></script>
@endsection
