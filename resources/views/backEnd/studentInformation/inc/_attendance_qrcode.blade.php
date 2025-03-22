<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Attendance QR Code</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 text-center">
                    {!! QrCode::size(300)->generate($qrcode) !!}
                </div>
            </div>

            {{-- <div class="mt-40 d-flex justify-content-between">
                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
            </div> --}}
        </div>

    </div>
</div>
