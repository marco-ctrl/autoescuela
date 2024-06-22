<div class="modal fade" id="modalHorasExtra" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHorasExtraTitle">Agregar Horas Extra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Estudiante <strong>{{ $matricula->estudiante->es_nombre }}
                                    {{ $matricula->estudiante->es_apellido }}</strong></h6>
                            <h6>Curso: <strong>{{ $matricula->curso->cu_descripcion }}</strong></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Categoria: <strong>{{ $matricula->ma_categoria }}</strong></h6>
                        </div>
                    </div>
                </div>
                <form id="formhorasExtra">
                    <div class="form-group">
                        <label for="duracion">Duracion Hrs.</label>
                        <input type="number" name="duracion" id="duracion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="costo">Costo Bs</label>
                        <input type="number" name="costo" id="costo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="importe">Importe Bs</label>
                        <input type="number" name="importe" id="importe" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarHoraExtra">Guardar</button>
            </div>
        </div>
    </div>
</div>