@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Matricula</h6>
        </div>
        <div class="card-body container-fluid justify-content-center">
            <form id="form" autocomplete="off">
                @include('admin.matricula._partials.form')
                <button type="submit" class="btn btn-primary">Matricular</button>
                <a href="{{ route('admin.matriculas.index') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalRegistrarEstudiante" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                            <button id="btn-guardar" type="submit" class="btn btn-primary apagar"><i
                                    class="fas fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('admin.components.modal-success-estudinate')

    @include('admin.components.modal-success', [
        'title' => 'Matriculacion registrada',
        'message' => 'La matriculacion se ha registrado correctamente',
        'objeto' => 'matricula',
        'btn' => 'Asignar Horarios',
        'iconBtn' => '<i class="fas fa-calendar-check"></i>',
    ])
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/matricula/form.js') }}"></script>
    <script src="{{ asset('js/admin/capturar_foto.js') }}"></script>
    <script src="{{ asset('js/admin/estudiante/estudianteAutocomplete.js') }}"></script>
    <script src="{{ asset('js/admin/curso/cursoAutocomplete.js') }}"></script>
    <script src="{{ asset('js/admin/estudiante/validacion.js') }}"></script>
@endsection
