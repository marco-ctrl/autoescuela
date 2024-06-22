<div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asistencia</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h5>Curso: <strong id="curso"></strong></h5>
                    <h5>Estudiante: <strong id="estudiante"></strong></h5>
                    <h5>Categoria: <strong id="categoria"></strong></h5>
                </div>
                <form id="formHorario" class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <div class="form-group">
                                    <label for="tema">Tema</label>
                                    <input type="text" id="tema" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="asistencia">Asistencia
                                    <input type="checkbox" id="asistencia" class="form-control" value="0">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-group">
                                    <label for="nota">Nota</label>
                                    <input type="number" id="nota" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="justificacion">Justificacion</label>
                                <input type="text" id="justificacion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observacion">Oberservacion</label>
                                <input type="text" id="observacion" class="form-control">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="codigo" required>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" type="button" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalOcupado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="text-center">Docente: <strong id="docenteOcupado"></strong></h4>
                    <h5>Curso: <strong id="cursoOcupado"></strong></h5>
                    <h5>Estudiante: <strong id="estudianteOcupado"></strong></h5>
                    <h5>Categoria: <strong id="categoriaOcupado"></strong></h5>
                    <h5>Estado: <strong>OCUPADO</strong></h5>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
