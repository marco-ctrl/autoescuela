@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Estudiantes</h6>
        </div>
        <div class="card-body">
            <form class="form-row">
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <input type="search" class="form-control" id="buscar" aria-label="Search" aria-describedby="basic-addon2" placeholder="Buscar...">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-search"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.estudiante.create') }}" 
                    class="btn btn-success mb-2" title="Agregar Estudiante"><i
                        class="fas fa-plus"></i></a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-small" id="estudianteTable" width="100%"
                    cellspacing="0">
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
                            @include('admin.estudiante._partials.form')
                        </div>
                        <div class="modal-footer">
                            <button id="btn-siguiente" type="button" class="btn btn-secondary apagar" data-dismiss="modal"
                                style="display: none;"><i class="fas fa-chevron-right"></i> Siguiente</button>
                            <button id="btnGuardar" type="button" class="btn btn-primary apagar"><i
                                    class="fas fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/estudiante/lista.js') }}"></script>
    <script src="{{ asset('js/admin/capturar_foto.js') }}"></script>
@endsection
