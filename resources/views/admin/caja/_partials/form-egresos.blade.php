<form id="egresoForm">
    <div class="form-group">
        <label for="estudiante">Emitido</label>
        <input class="form-control estudiante" id="emitido" placeholder="Emitido a nombre de...">
    </div>
    <div id="detallesContainer">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="detalle">Detalle</label>
                <input class="form-control" id="detalle" placeholder="Detalle">
                <input type="hidden" id="detalleId">
            </div>
            <div class="form-group col-md-2">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" placeholder="Cantidad">
            </div>
            <div class="form-group col-md-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" placeholder="Precio">
            </div>
            <div class="form-group col-md-3">
                <label for="">Agregar</label><br>
                <button type="button" class="btn btn-primary" id="addDetalleBtn">
                    <i class="fas fa-cart-arrow-down"></i>
                </button>
            </div>
        </div>
        </div>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="detallesTableBody">
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Sumatoria Total</th>
                <th id="sumatoriaTotal">0</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <button type="button" class="btn btn-danger cancelar" id="cancelarBtn">Cancelar</button>
    <button type="button" class="btn btn-success" id="guardarBtn">Guardar</button>
</form>