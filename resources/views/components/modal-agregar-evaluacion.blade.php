<div class="modal fade" id="modalAgregarEvaluacion" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarEvaluacionTitle">Agregar Evaluacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Estudiante: <strong id="estudianteEvaluacion"></strong></h6>
                            <h6>Curso: <strong id="cursoEvaluacion"></strong></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Categoria: <strong id="categoriaEvaluacion"></strong></h6>
                        </div>
                    </div>
                </div>
                <form id="formAgregarEvaluacion">
                    <div class="form-group">
                        <label for="costoEvaluacion">Costo Bs</label>
                        <input type="number" name="costo" id="costoEvaluacion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="importeEvaluacion">Importe Bs</label>
                        <input type="number" name="importe" id="importeEvaluacion" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarEvaluacion">Guardar</button>
            </div>
        </div>
    </div>
</div>
