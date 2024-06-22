<div class="modal fade" id="modalAgregarCurso" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarCursoTitle">Agregar Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Estudiante: <strong id="estudianteCurso"></strong></h6>
                            <h6>Curso: <strong id="cursoCurso"></strong></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Categoria: <strong id="categoriaCurso"></strong></h6>
                            <h6>Edad: <strong id="edadCurso"></strong></h6>
                        </div>
                    </div>
                </div>
                <form id="formEditarCurso" autocomplete="off">
                    <div class="form-group">
                        <label for="curso">Seleccione un Curso</label>
                        <input class="form-control" id="curso" placeholder="Seleccione un Curso" autocomplete="off">
                        <input type="hidden" name="cu_codigo" id="cu_codigo">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ma_duracion">Duracion Hrs.</label>
                                <input type="number" name="ma_duracion" id="ma_duracion" class="form-control" min="1"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ma_costo_curso">Costo Curso Bs.</label>
                                <input type="number" name="ma_costo_curso" id="ma_costo_curso" class="form-control" min="0" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="paga">Paga Bs.*</label>
                        <input type="number" name="importe" id="importe" class="form-control" min="0" disabled required>
                    </div>
            
                    <div class="form-group">
                        <label for="saldo">Saldo Bs.</label>
                        <input class="form-control" name="saldo" id='saldo' readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarCurso">Guardar</button>
            </div>
        </div>
    </div>
</div>
