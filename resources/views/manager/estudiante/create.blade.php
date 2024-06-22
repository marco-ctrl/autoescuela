@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Estudiante</h6>
        </div>
        <div class="card-body">
            <form id="formEstudiante" autocomplete="off">
            <div class="row">
                @include('manager.estudiante._partials.form')
            </div>
            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
            <a href="{{ route('manager.estudiante.index') }}" class="btn btn-danger">Cancelar</a>
        </form>
        </div> 
    </div>
    
    @include('manager.components.modal-success', [
        'title' => 'Registro exitoso',
        'message' => 'El estudiante se registró correctamente.',
        'route' => 'manager.estudiante.index',
        'objeto' => 'estudiante',
        'btn' => 'Aceptar',
        'iconBtn' => '<i class="fas fa-check"></i>'
        ])
@endsection
@section('scripts')
    <script src="{{ asset('js/manager/capturar_foto.js') }}"></script>
    <script src="{{ asset('js/manager/estudiante/form.js') }}"></script>
    <script>
        document.getElementById('es_tipodocumento').addEventListener('change', function() {
            var tipoDocumento = this.value;
            var documentoInput = document.getElementById('es_documento');
            if (tipoDocumento === '2') { // CE seleccionado
                if (!documentoInput.value.startsWith('E-')) {
                    documentoInput.value = 'E-';
                }
            } else {
                if (documentoInput.value.startsWith('E-')) {
                    documentoInput.value = documentoInput.value.substring(2); // Remover 'E-' si se cambia a otro tipo
                }
            }
        });
    </script>
@stop
