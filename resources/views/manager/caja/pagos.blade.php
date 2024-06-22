@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pago Cuotas</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-auto">
                    <form class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" autocomplete="off">
                        <div class="input-group">
                            <input type="text" id="buscarEstudiante" class="form-control bg-light border-0 small" 
                            placeholder="Buscar Estudiante..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button id="btnBuscarEstudiante" class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-small" id="matriculaTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>MATRICULA</th>
                            <th>DOCUMENTO</th>
                            <th>ALUMNO</th>
                            <th>USUARIO</th>
                            <th>SERVICIO</th>
                            <th>TOTAL BS.</th>
                            <th>INSCRIPCION</th>
                            <th>PRIMERA CUOTA</th>
                            <th>ULTIMA CUOTA</th>
                            <th>CAN. BS.</th>
                            <th>SALDO BS.</th>
                            <th>ESTADO</th>
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

    @include('components.modal-pago-cuota')

    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF de Credenciales del Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCerrar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/manager/caja/pagos.js') }}"></script>
@endsection
