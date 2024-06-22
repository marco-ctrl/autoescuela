@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pagar Docente</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-auto">
                    <form class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" autocomplete="off">
                        <div class="input-group">
                            <input type="text" id="buscarDocente" class="form-control bg-light border-0 small" 
                            placeholder="Buscar Docente..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button id="btnBuscarDocente" class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="docenteTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>FOTO</th>
                            <th>DOCUMENTO</th>
                            <th>NOMBRE</th>
                            <th>PAGO HORA</th>
                            <th>HORAS PAGADAS</th>
                            <th>HORAS NO PAGADAS</th>
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
                    <h3 class="text-center" id="faltaPagar"></h3>
                    <h4 class="text-center" id="sueldoHora"></h4>
                    <form id="formPago" class="mt-3">
                        <div class="form-group">
                            <label for="horas">Horas a Pagar</label>
                            <input type="number" name="horas" id="horas" min="0" class="form-control" value="0dfcn">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnPagarDocente">Pagar</button>
                </div>
            </div>
        </div>
    </div>
    @include('components.modal-pdf')
@endsection
@section('scripts')
<script src="{{ asset('js/manager/caja/pagarDocente.js') }}"></script>
<script src="{{ asset('js/pdfModal.js')}}"
@endsection
