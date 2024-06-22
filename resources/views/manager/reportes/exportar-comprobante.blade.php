@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Exportar Comprobante</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <form id="form" class="form-inline" method="POST" action="{{ route('manager.pdf.exportar-comprobante') }}" target="_blank">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="fecha">Fecha Incial </label>
                            <input type="date" id="fechaInicial" name="fechaInicial" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="fecha">Fecha Final </label>
                            <input type="date" id="fechaFinal" name="fechaFinal" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <input type="hidden" id="usuario" name="usuario">
                        <button class="btn btn-primary mb-2" type="button" id="btn-filtrar" title="Filtrar"><i
                                class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-danger mb-2" type="submit" id="btn-pdf" title="Generar PDF">
                            <i class="far fa-file-pdf"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-sm text-small text-center"
                    id="ingresosTable" width="100%" cellspacing="0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>Nro.</th>
                            <th>FECHA</th>
                            <th>DOCUMENTO</th>
                            <th>DETALLE</th>
                            <th>USUARIO</th>
                            <th>ESTUDIANTE</th>
                            <th>MONTO BS.</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
@include('components.modal-pdf')
@endsection
@section('scripts')
    <script src="{{ asset('js/manager/reportes/exportarComprobante.js') }}"></script>
    <script src="{{ asset('js/pdfModal.js') }}"></script>
@endsection
