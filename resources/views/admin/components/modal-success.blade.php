<div class="modal fade" id="successModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">{{ $title }}</h5>
            </div>
            <div class="modal-body" id="successModalBody">
                {{ $message }}
            </div>
            <div class="modal-footer">
                @if ($objeto == 'matricula')
                    <a href="#" id="pdfA4" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> PDF A4</a>
                    <a href="#" id="pdfTicket" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> PDF Ticket</a>
                @endif
                <button type="button" class="btn btn-primary" id="acceptBtn" data-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>