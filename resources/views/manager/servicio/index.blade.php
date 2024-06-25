@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Servicios</h6>
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
                <button type="button" id="btnAgregar" class="btn btn-success mb-2" title="Agregar Certificado">
                    <i class="fas fa-plus"></i> Agregar</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm text-small" id="matriculaTable" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>DOCUMENTO</th>
                            <th>ALUMNO</th>
                            <th>USUARIO</th>
                            <th>SERVICIO</th>
                            <th>TOTAL BS.</th>
                            <th>PRIMERA CUOTA</th>
                            <th>ULTIMA CUOTA</th>
                            <th>CAN. BS.</th>
                            <th>SALDO BS.</th>
                            <th>ESTADO</th>
                            <th colspan="3" class="text-center">ACCIONES</th>
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
                    <h5 class="modal-title" id="modalPagoTitle">Pago Cuota Servicios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="col-12 text-center">
                        <h5>Servicio: <strong id="servicioDescripcion"></strong></h5>
                        <h5>Estudiante: <strong id="nombreEstudiante"></strong></h5>
                        <h5>Nro Documento: <strong id="nroDocumento"></strong></h5>
                        <h5>Saldo Bs: <strong id="saldoCertificado"></strong></h5>
                    </div>
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

    <div class="modal fade" id="modalEntregarCertificado" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoTitle">Entregar <strong class="descripcionCert"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h2 class="text-primary">
                                <i class="fas fa-question-circle fa-2x"></i>
                            </h2>
                        </div>
                        <div class="col-md-8 text-center">
                            <h6>¿Esta seguro que desea entregar <strong class="descripcionCert"></strong> a?</h6>
                            <hr>
                            <h5>Estudiante: <strong id="nombreEstudianteEntrega"></strong></h5>
                            <h5>Nro Documento: <strong id="nroDocumentoEntrega"></strong></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnEntregar">Entregar</button>
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-pdf')

    <div class="modal fade" id="modalRegistrarServicio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoTitle">Registrar Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <form id="formCertificado">
                        <div class="form-group">
                            <label for="estudiante">Seleccione un Estudiante*</label>
                            <input class="form-control estudiante" id="estudiante" placeholder="Seleccione un Estudiante"
                                autocomplete="off" required>
                            <input type="hidden" name="es_codigo" id="es_codigo">
                        </div>
                        <div class="form-group">
                            <label for="servicio">Seleccione un Servicio*</label>
                            <select class="form-control servicio" id="servicio" required>
                                <option value="">Seleccione un Servicio</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->sv_codigo }}" data-precio="{{ $servicio->sv_precio }}">{{ $servicio->sv_descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="costo">Costo</label>
                            <input type="number" name="costo" id="costo" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="importe">Importe</label>
                            <input type="number" name="importe" id="importe" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="saldo">Saldo</label>
                            <input type="number" name="saldo" id="saldo" class="form-control" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnRegistrar">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <script src="{{ asset('js/manager/servicio/index.js') }}"></script>
    <script src="{{ asset('js/pdfModal.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#servicio').change(function() {
                var selectedOption = $(this).find('option:selected');
                var precio = selectedOption.data('precio');
                if (precio !== undefined) {
                    $('#costo').val(precio).prop('disabled', false);
                    $('#saldo').val(precio);
                    // Actualizar el importe y el saldo
                    var importe = $('#importe').val() || 0;
                    var saldo = $('#costo').val() || 0;
                    if(importe > saldo)
                    {
                        $('#importe').val(saldo);
                        
                    }
                    else{
                        var nuevoSaldo = saldo - importe;
                        $('#saldo').val(nuevoSaldo);
                    }
                    
                    //$('#saldo').val(nuevoSaldo);
                    
                    // Actualizar el saldo en el formulario
                } else {
                    $('#costo').val('').prop('disabled', true);
                }
            });
        });
    </script>
@endsection
