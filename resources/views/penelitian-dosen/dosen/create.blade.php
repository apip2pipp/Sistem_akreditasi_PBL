<form id="form-tambah" action="{{ route('penelitian-dosen.store') }}" method="post">
    @csrf

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Research Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- No Surat Tugas --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No Assignment Letter</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="no_surat_tugas" required>
                        <small id="error-no_surat_tugas" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Judul Penelitian --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Research Title</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="judul_penelitian" required>
                        <small id="error-judul_penelitian" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Pendanaan Internal --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Internal Funding</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pendanaan_internal">
                        <small id="error-pendanaan_internal" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Pendanaan Eksternal --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">External Funding</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pendanaan_eksternal">
                        <small id="error-pendanaan_eksternal" class="form-text text-danger error-text"></small>
                    </div>
                </div>
                {{-- link_penelitian --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Research Links</label>
                    <div class="col-10">
                        <textarea name="link_penelitian" id="link_penelitian" class="form-control"></textarea>
                        <small id="error-link_penelitian" class="form-text text-danger error-text"></small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script>
    $(document).ready(function() {
        $('#link_penelitian').summernote({
            placeholder: 'Enter the research link or description',
            tabsize: 2,
            height: 200, // Adjust height of the editor
        });
        $('#form-tambah').validate({
            rules: {
                no_surat_tugas: {
                    required: true
                },
                judul_penelitian: {
                    required: true
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res, textStatus, xhr) {
                        if (xhr.status === 200) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            });

                            dataMaster.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error has occurred',
                            text: xhr.responseJSON?.message ||
                                'An error has occurred!'
                        });

                        if (xhr.responseJSON?.msgField) {
                            $('.error-text').text('');
                            $.each(xhr.responseJSON.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
