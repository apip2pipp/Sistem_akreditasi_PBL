<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Penelitian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            {{-- No Surat Tugas --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">No Surat Tugas</label>
                <div class="col-10">
                    <input type="text" class="form-control"
                        value="{{ $penelitianDosen->penelitian->no_surat_tugas }}" readonly>
                </div>
            </div>

            {{-- Judul Penelitian --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Judul Penelitian</label>
                <div class="col-10">
                    <input type="text" class="form-control"
                        value="{{ $penelitianDosen->penelitian->judul_penelitian }}" readonly>
                </div>
            </div>

            {{-- Pendanaan Internal --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Pendanaan Internal</label>
                <div class="col-10">
                    <input type="text" class="form-control"
                        value="{{ $penelitianDosen->penelitian->pendanaan_internal ?? 'Tidak ada' }}" readonly>
                </div>
            </div>

            {{-- Pendanaan Eksternal --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Pendanaan Eksternal</label>
                <div class="col-10">
                    <input type="text" class="form-control"
                        value="{{ $penelitianDosen->penelitian->pendanaan_eksternal ?? 'Tidak ada' }}" readonly>
                </div>
            </div>

            {{-- Link Penelitian --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Link Penelitian</label>
                <div class="col-10">
                    <textarea name="link_penelitian" id="link_penelitian" class="form-control" readonly>{!! $penelitianDosen->penelitian->link_penelitian !!}</textarea>
                    <small id="error-link_penelitian" class="form-text text-danger error-text"></small>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>


<!-- Include Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#link_penelitian').summernote({
            height: 200,
            toolbar: false,
            disableResizeEditor: true,
            airMode: false,
            disableDragAndDrop: true
        });
        $('#link_penelitian').summernote('disable'); // ini penting
    });
</script>
