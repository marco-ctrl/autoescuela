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
                            <th>EXP.</th>
                            <th>NOMBRES</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>USUARIO</th>
                            <th>CAT.</th>
                            <th>SEDE</th>
                            <th>CURSO</th>
                            <th>COSTO</th>
                            <th>CANC.</th>
                            <th>SALDO</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA EVALUACION</th>
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

    <div class="modal fade" id="modalEvaluacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEvaluacionTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <form id="formEvaluacion">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="datetime-local" name="fecha" id="fecha" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="sede">Sede</label>
                            <select class="form-control" name="sede" id="sede">
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnEvaluacion">Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/matricula/lista.js') }}"></script>
@endsection
