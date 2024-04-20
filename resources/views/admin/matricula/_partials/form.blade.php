<div class="row">
    <div class="col-md-6 col-lg-5 col-sm-12">
        <div class="form-group">
            <label for="estudiante">Seleccione un Estudiante*</label>
            <input class="form-control estudiante" id="estudiante"  placeholder="Seleccione un Estudiante" autocomplete="off" required>
            <input type="hidden" name="es_codigo" id="es_codigo">
        </div>

        <div class="form-group">
            <label for="curso">Seleccione un Curso*</label>
            <input class="form-control" id="curso" placeholder="Seleccione un Curso" autocomplete="off" required>
            <input type="hidden" name="cu_codigo" id="cu_codigo">
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="ma_duracion">Duracion Hrs.</label>
                    <input type="number" name="ma_duracion" id="ma_duracion" class="form-control" min="1" disabled>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ma_costo">Costo Bs.</label>
                    <input type="number" name="ma_costo" id="ma_costo" class="form-control" min="0" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="salida">Salida</label>
                    <select class="form-control" id="salida" name="salida">
                        <option value="" selected>Seleccione una Salida</option>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="placa">Placa</label>
                    <select class="form-control" id="am_codigo" name="am_codigo">
                        <option value="" selected>Seleccione una Salida</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="sede">Sede*</label>
            <select class="form-control" id="se_codigo" name="se_codigo" required>
                <option selected>Seleccione una Sede</option>
            </select>
        </div>

    </div>

    <div class="col-md-6 col-lg-5 col-sm-12">
        <div class="form-group">
            <label for="categoria">Categoria*</label>
            <select class="form-control" id="ma_categoria" name="ma_categoria" required>
                <option selected>Seleccione una Categoria</option>
            </select>
        </div>
        <div class="form-group">
            <label for="paga">Paga Bs.*</label>
            <input type="number" name="importe" id="importe" class="form-control" min="0" disabled required>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="false" id="pagado" name="pagado" disabled />
                <label class="form-check-label" for="pagado">¿Pagado?</label>
            </div>
        </div>

        <div class="form-group">
            <label for="saldo">Saldo Bs.</label>
            <input class="form-control" name="saldo" id='saldo' readonly>
        </div>

        <div class="form-group">
            <label for="detalle_recojo">Detalle Recojo</label>
            <textarea class="form-control" cols="2" name="detalle_recojo" id="detalle_recojo"
                placeholder="Ingrese el Detalle"></textarea>
        </div>
    </div>

</div>
