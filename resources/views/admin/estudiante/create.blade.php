@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Estudiante</h6>
        </div>
        <div class="card-body">
            <form id="formEstudiante" autocomplete="off">
            <div class="row">
                @include('admin.estudiante._partials.form')
            </div>
            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
            <a href="{{ route('admin.estudiante.index') }}" class="btn btn-danger">Cancelar</a>
        </form>
        </div> 
    </div>
    
    @include('admin.components.modal-success', [
        'title' => 'Registro exitoso',
        'message' => 'El estudiante se registró correctamente.',
        'route' => 'admin.estudiante.index',
        'objeto' => 'estudiante',
        'btn' => 'Aceptar',
        'iconBtn' => '<i class="fas fa-check"></i>'
        ])
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/capturar_foto.js') }}"></script>
    <script src="{{ asset('js/admin/estudiante/form.js') }}"></script>
@stop
