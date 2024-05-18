@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ingresos</h6>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <button class="btn btn-primary" id="btnNuevoIngreso" data-toggle="modal" data-target="#modalIngresos">Nuevo
                    Ingreso <i class="fas fa-plus"></i></button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-sm text-small" id="ingresosTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>FECHA</th>
                            <th>MONTO BS.</th>
                            <th>DETALLE</th>
                            <th>USUARIO</th>
                            <th>ESTUDIANTE</th>
                            <th>OPCIONES</th>
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

    <div class="modal fade" id="modalIngresos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalIngresoTitle">Registrar Ingreso</h5>
                    <button type="button" class="close cancelar" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    @include('admin.caja._partials.form-ingresos')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/caja/ingresos.js') }}"></script>
    <script src="{{ asset('js/admin/caja/formIngresos.js') }}"></script>
@endsection
