@extends('admin.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    @if ($matricula->cu_codigo == null)
        <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Pagina no Funciona</p>
            <p class="text-gray-500 mb-0">Este Estudiante
                {{ $matricula->estudiante->es_nombre }}
                {{ $matricula->estudiante->es_apellido }} no tiene un curso y cantidad de horas asignado</p>
            <a href="{{ route('admin.matriculas.index') }}" class="btn btn-primary mt-5">&larr; Volver Listado de
                Matriculados</a>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Agregar Horarios para el Estudiante
                    {{ $matricula->estudiante->es_nombre }}
                    {{ $matricula->estudiante->es_apellido }}</h5>
                <h6 class="m-0 font-weight-bold text-primary">Curso: {{ $matricula->curso->cu_descripcion }}&emsp;
                    Duracion: <strong id="duracionCurso">{{ $matricula->ma_duracion_curso }}Hrs.</strong>&emsp;</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <div id="form" class="form-inline">
                            <input type="hidden" id="ma_codigo" name="ma_codigo" value="{{ $matricula->ma_codigo }}">
                            <div class="form-group mb-2">
                                <label for="docente">Seleccione un Docente* </label>
                                <input class="form-control" id="docente" name="docente"
                                    placeholder="Seleccione un docente" autocomplete="off">
                                <input type="hidden" name="do_codigo" id="do_codigo">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="hm_color">Color* </label>
                                <select class="form-control" id="hm_color" name="hm_color">
                                    <option selected>Seleccione un Color</option>
                                    <option value="bg-primary" class="bg-primary">Azul</option>
                                    <option value="bg-success" class="bg-success">Verde</option>
                                    <option value="bg-danger" class="bg-danger">Rojo</option>
                                    <option value="bg-warning" class="bg-warning">Amarillo</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <button type="button" id="btn-agregar" class="btn btn-success" title="Agregar Horas Extra">
                                    <i class="fas fa-calendar-plus"></i></button>
                            </div>
                            <div class="form-group mb-2 ml-2">
                                <button type="button" id="btn-ver" class="btn btn-primary" title="Ver">
                                    <i class="fas fa-clipboard-list"></i></button>
                            </div>
                            <div class="form-group mb-2 ml-2">
                                <button type="button" id="btn-imprimir" class="btn btn-danger" title="imprimir">
                                    <i class="fas fa-file-pdf"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div id='calendario'></div>
                    </div>
                    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h2 id="modalTitulo"></h2>
                                    <p id="modalInicio"></p>
                                    <p id="modalFin"></p>
                                    <p id="modalDocente"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalTableHorarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Horario Clases</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="thead-dark">
                                    <th>Fecha</th>
                                    <th>Hr. Inicio</th>
                                    <th>Hr. Final</th>
                                    <th>Docente</th>
                                    <th>Accion</th>
                                </thead>
                                <tbody id='horarios'>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('components.modal-asistencia')
        @include('components.modal-horas-extra', $matricula)
        @include('components.modal-pdf')
    @endif
@endsection

@section('styles')
    <link href='https://unpkg.com/fullcalendar@5/main.min.css' rel='stylesheet' />
@endsection

@section('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js'></script>
    <!--<script src='https://unpkg.com/fullcalendar@5/main.min.js'></script>-->
    <script src="{{ asset('vendor/fullcalendar-6.1.11/dist/index.global.js') }}"></script>
    <script src="{{ asset('js/admin/horario_matricula/form.js') }}"></script>
    <script src="{{ asset('js/admin/horario_matricula/agregarHorasExtra.js') }}"></script>
    <script src="{{ asset('js/pdfModal.js') }}"></script>
@endsection
