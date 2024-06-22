<div class="modal fade" id="modalPago" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPagoTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <h5>Saldo Bs.: <strong id="saldoMatricula"></strong></h5>
                </div>
                <form id="formPago">
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <select name="pc_tipo" id="documento" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pc_tipo">Tipo de Pago</label>
                        <select name="pc_tipo" id="pc_tipo" class="form-control">
                            <option value="0">EFECTIVO</option>
                            <option value="1">TRANSFERENCIA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pc_monto">Monto</label>
                        <input type="number" name="pc_monto" id="pc_monto" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnPago">Pagar</button>
            </div>
        </div>
    </div>
</div>
