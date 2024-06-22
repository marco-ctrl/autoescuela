@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Historial Estudiante</h6>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <form class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" autocomplete="off">
                    <div class="input-group">
                        <input type="text" id="buscarEstudiante" class="form-control bg-light border-0 small" placeholder="Buscar..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="btnBuscarEstudiante" class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm 
                text-small text-center" id="matriculaTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>FOTO</th>
                            <th>NRO KARDEX</th>
                            <th>FECHA DE INSCRIPCION</th>
                            <th>DOCUMENTO CI</th>
                            <th>EXP.</th>
                            <th>ALUMNO</th>
                            <th>USUARIO</th>
                            <th>CAT.</th>
                            <th>SEDE</th>
                            <th>CURSO</th>
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

    @include('components.modal-pdf')
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/reportes/historialEstudiante.js') }}"></script>
    <script src="{{ asset('js/pdfModal.js') }}"></script>
    @endsection
