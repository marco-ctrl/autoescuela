@extends('manager.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Matricula</h6>
        </div>
        <div class="card-body container-fluid justify-content-center">
            <form id="form" autocomplete="off">
                @include('manager.matricula._partials.form')
                <button type="submit" class="btn btn-primary">Matricular</button>
                <a href="{{ route('manager.matriculas.index') }}" class="btn btn-danger">Cancelar</a>
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
                            @include('manager.estudiante._partials.form')
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger" href="{{ route('manager.matriculas.index') }}"><i class="fas fa-times-circle"></i> Cancelar</a>
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

    @include('manager.components.modal-success-estudinate')

    @include('manager.components.modal-success', [
        'title' => 'Matriculacion registrada',
        'message' => 'La matriculacion se ha registrado correctamente',
        'objeto' => 'matricula',
        'btn' => 'Asignar Horarios',
        'iconBtn' => '<i class="fas fa-calendar-check"></i>',
    ])

    @include('components.modal-pdf')
@endsection

@section('scripts')
    <script src="{{ asset('js/manager/matricula/form.js') }}"></script>
    <script src="{{ asset('js/manager/capturar_foto.js') }}"></script>
    <script src="{{ asset('js/manager/estudiante/estudianteAutocomplete.js') }}"></script>
    <script src="{{ asset('js/manager/estudiante/documentoExtranjero.js') }}"></script>
    <script src="{{ asset('js/pdfModal.js') }}"></script>
@endsection
