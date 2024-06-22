<div class="modal fade" id="modalEditarMatricula" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarMatriculaTitle">Editar Matricula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Estudiante: <strong id="estudianteMatricula"></strong></h6>
                            <h6>Curso: <strong id="cursoMatricula"></strong></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Categoria: <strong id="categoriaMatricula"></strong></h6>
                            <h6>Edad: <strong id="edadMatricula"></strong></h6>
                        </div>
                    </div>
                </div>
                <form id="formEditarMatricula">
                    <div class="form-group">
                        <label for="sede">Sede*</label>
                        <select class="form-control sede" id="sedeEditar" name="se_codigo" required>
                            <option selected>Seleccione una Sede</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria*</label>
                        <select class="form-control" id="ma_categoria" name="ma_categoria" required>
                            <option selected>Seleccione una Categoria</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnEditarMatricula">Guardar</button>
            </div>
        </div>
    </div>
</div>
