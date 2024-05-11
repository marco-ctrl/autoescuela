<div class="col-md-6 col-sm-12 col-lg-4">
    <div class="row">
        <div class="col-md-3">
            <label for="es_tipodocumento">Tipo*</label>
            <select class="form-control" id="es_tipodocumento" name="es_tipodocumento">
                <option value="">Seleccione</option>
                <option value="1">CI</option>
                <option value="2">CE</option>
            </select>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="es_documento">Documento*</label>
                <input class="form-control estudiante" id="es_documento" name="es_documento"
                    placeholder="Ingresar Numero Documento" required />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="es_expedicion">Expedicion*</label>
                <select class="form-control" id="es_expedicion" name="es_expedicion">
                    <option value="">Seleccione</option>
                    <option value="QR">QR</option>
                    <option value="LP">LP</option>
                    <option value="CB">CB</option>
                    <option value="SC">SC</option>
                    <option value="OR">OR</option>
                    <option value="PT">PT</option>
                    <option value="TJ">TJ</option>
                    <option value="CH">CH</option>
                    <option value="BE">BE</option>
                    <option value="PD">PD</option>
                </select>
            </div>
        </div>

    </div>
    <div class="form-group">
        <label for="es_nombre">Nombres*</label>
        <input type="text" class="form-control" id="es_nombre" name="es_nombre" placeholder="Ingresar Nombres"
            required />
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ape_paterno">Apellido Paterno</label>
                <input type="text" class="form-control" id="ape_paterno" name="ape_paterno" placeholder="Ingresar Apellido Paterno"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ape_materno">Apellido Materno</label>
                <input type="text" class="form-control" id="ape_materno" name="ape_materno" placeholder="Ingresar Apellido Materno"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="es_nacimiento">Fecha de Nacimiento*</label>
        <input type="date" class="form-control" id="es_nacimiento" name="es_nacimiento"
            placeholder="Ingresar Fecha de Nacimiento" required />
    </div>
    <div class="form-group">
        <label for="es_celular">Numero de Contacto*</label>
        <input type="tel" class="form-control" id="es_celular" name="es_celular"
            placeholder="Ingresar Numero de Contacto" required />
    </div>
</div>
<div class="col-md-6 col-sm-12 col-lg-4">
    <div class="form-group">
        <p><strong>Genero*</strong></p>
        <label class="mr-2">
            <input type="radio" id="femenino" name="es_genero" value="0" checked>
            Femenino
        </label>
        <label class="mr-2">
            <input type="radio" id="masculino" name="es_genero" value="1">
            Masculino
        </label>
    </div>
    <div class="form-group">
        <label for="es_direccion">Direccion*</label>
        <textarea class="form-control" id="es_direccion" name="es_direccion" placeholder="Ingresar Direccion" required></textarea>
    </div>
    <div class="form-group">
        <label for="es_oberservacion">Observacion</label>
        <textarea class="form-control" id="es_observacion" name="es_observacion" placeholder="Ingresar Observacion"></textarea>
    </div>
    <div class="form-group">
        <label for="es_correo">Correo Electronico</label>
        <input type="email" class="form-control" id="es_correo" name="es_correo"
            placeholder="Ingresar Correo Electronico" />
    </div>
</div>
<div class="col-md-12 col-sm-12 col-lg-4">
    <div class="d-block d-sm-block d-md-none">
        <button type="button" class="btn btn-secondary btn-block"
            onclick="document.getElementById('file-upload').click();">
            <i class="fas fa-camera"></i> Tomar Foto</button>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 d-none d-sm-none d-md-block">
            <button type="button" id="encender"
                class="btn btn-success btn-block
                    text-center"><i class="fas fa-video "></i>
                Encender</button>
        </div>
        <div class="col-md-6 d-none d-sm-none d-md-block">
            <button type="button" id="apagar" class="btn btn-danger btn-block
                    text-center"><i
                    class="fas fa-video-slash "></i> Apagar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-2 d-none d-sm-none d-md-block">
            <div class="video-wrap">
                <video id="video" width="140" height="120" poster="{{ asset('img/undraw_profile.svg') }}">
                </video>
                <!--<canvas id="canvas" width="140" height="120"></canvas>-->
            </div>

        </div>
        <div class="col-md-6 p-2">
            <img id="imagen" width="140" height="120">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-2 d-none d-sm-none d-md-block">
            <!-- Trigger canvas web API -->
            <div class="controller ">
                <button type="button" id="snap"
                    class="btn btn-secondary btn-block
                    text-center"><i class="fas fa-camera "></i>
                    Capturar</button>
            </div>
        </div>
        <div class="col-md-6 p-2 d-none d-sm-none d-md-block">
            <div class="controller">
                <button type="button" class="btn btn-secondary btn-block"
                    onclick="document.getElementById('file-upload').click();">
                    <i class="fas fa-search-plus "></i> Buscar Foto</button>
                <input type="file" style="display:none;" id="file-upload" aria-describedby="fileHelp">
            </div>
        </div>
        <div class="col-md-6 p-2 d-none d-sm-none d-md-block">
            <div class="controller">
                <button type="button" class="btn btn-secondary btn-block"
                    onclick="document.getElementById('file-upload').click();" hidden>
                    <i class="fas fa-search-plus "></i> Buscar Foto</button>
                <input type="file" style="display:none;" id="file-upload" aria-describedby="fileHelp">
            </div>
        </div>
    </div>
    <canvas id="canvas" width="140" height="120" style="display: none;"></canvas>
    <input type="hidden" id="es_foto" name="es_foto">
</div>
