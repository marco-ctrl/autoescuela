@extends('docente.layouts.app')
@section('title', 'Autoescuela')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Asistencia</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div id='calendario'></div>
                </div>

            </div>
        </div>
    </div>
    @include('components.modal-asistencia')
@endsection

@section('styles')
    <link href='https://unpkg.com/fullcalendar@5/main.min.css' rel='stylesheet' />
@endsection

@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js'></script>
<!--<script src='https://unpkg.com/fullcalendar@5/main.min.js'></script>-->
<script src="{{ asset('vendor/fullcalendar-6.1.11/dist/index.global.js') }}"></script>
<script src="{{ asset('js/docente/asistencia/form.js') }}"></script>
@endsection
