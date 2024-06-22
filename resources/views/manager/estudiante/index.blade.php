@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Estudiantes</h6>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                    autocomplete="off">
                    <div class="input-group">
                        <input type="text" id="buscarEstudiante" class="form-control bg-light border-0 small"
                            placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="btnBuscarEstudiante" class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('manager.estudiante.create') }}" class="btn btn-success mb-2" title="Agregar Estudiante"><i
                        class="fas fa-plus"></i> Agregar</a>
            </div>
            <div class="table-responsive">

                <table class="table table-bordered table-hover table-sm text-small text-center" id="estudianteTable"
                    width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>FOTO</th>
                            <th>DOCUMENTO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>CORREO</th>
                            <th>DIRECCION</th>
                            <th>CELULAR</th>
                            <th>EDAD</th>
                            <th>USUARIO</th>
                            <th>ESTADO</th>
                            <th colspan="2">ACCION</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyEstudiante">
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

    <div class="modal fade" id="modalEditarEstudiante" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Estudiante</h5>
                </div>
                <div class="modal-body">
                    <form id="formEstudiante" autocomplete="off">
                        <div class="row">
                            @include('manager.estudiante._partials.form')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger apagar" data-dismiss="modal">
                                <i class="fas fa-times-circle"></i> Cancelar</button>
                            <button id="btnGuardar" type="button" class="btn btn-primary apagar"><i
                                    class="fas fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @include('components.modal-pdf')
@endsection
@section('scripts')
    <script src="{{ asset('js/manager/estudiante/lista.js') }}"></script>
    <script src="{{ asset('js/manager/capturar_foto.js') }}"></script>
@endsection
