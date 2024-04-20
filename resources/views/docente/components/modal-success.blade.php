<div class="modal fade" id="successModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="successModalBody">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="acceptBtn" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>