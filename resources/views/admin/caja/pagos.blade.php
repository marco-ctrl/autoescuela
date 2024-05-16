@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pago Cuotas</h6>
        </div>
        <div class="card-body">
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
                            <th>CANCELADO</th>
                            <th>SALDO</th>
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

    <div class="modal fade" id="modalPago" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <form id="formPago">
                        <div class="form-group">
                            <label for="documento">Documento</label>
                            <select name="pc_tipo" id="documento" class="form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pc_tipo">Tipo de Pago</label>
                            <select name="pc_tipo" id="pc_tipo" class="form-control">
                                <option value="0">EFECTIVO</option>
                                <option value="1">TRANSFERENCIA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pc_monto">Monto</label>
                            <input type="number" name="pc_monto" id="pc_monto" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnPago">Pagar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/caja/pagos.js') }}"></script>
@endsection
