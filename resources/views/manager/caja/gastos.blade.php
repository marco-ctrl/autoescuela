@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Egresos</h6>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <form class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" autocomplete="off">
                    <div class="input-group">
                        <input type="text" id="buscarEgresos" class="form-control bg-light border-0 small" 
                        placeholder="Buscar..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="btnBuscarEgresos" class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <button type="button" class="btn btn-success btn-sm" id="btnNuevoEgreso" data-toggle="modal" data-target="#modalEgresos">
                    <i class="fas fa-plus"></i> Agregar
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-sm text-small" id="egresosTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>FECHA</th>
                            <th>MONTO BS.</th>
                            <th>DETALLE</th>
                            <th>USUARIO</th>
                            <th>EMITIDO</th>
                            <th colspan="2">ACCIONES</th>
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

    <div class="modal fade" id="modalEgresos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEgresoTitle">Registrar Egreso</h5>
                    <button type="button" class="close cancelar" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    @include('manager.caja._partials.form-egresos')
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-pdf')
@endsection

@section('scripts')
    <script src="{{ asset('js/manager/caja/Egresos.js') }}"></script>
    <script src="{{ asset('js/manager/caja/formEgresos.js') }}"></script>
    <script src="{{ asset('js/pdfModal.js')}}"></script>
@endsection
