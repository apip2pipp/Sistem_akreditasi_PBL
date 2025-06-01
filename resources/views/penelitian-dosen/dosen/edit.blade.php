<form id="form-edit" action="{{ route('penelitian-dosen.update', $penelitianDosen->id_penelitian_dosen) }}" method="POST">
    @csrf
    @method('PUT')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Penelitian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- No Surat Tugas --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No Surat Tugas</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="no_surat_tugas"
                            value="{{ $penelitianDosen->penelitian->no_surat_tugas }}" required>
                        <small id="error-no_surat_tugas" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Judul Penelitian --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Judul Penelitian</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="judul_penelitian"
                            value="{{ $penelitianDosen->penelitian->judul_penelitian }}" required>
                        <small id="error-judul_penelitian" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Pendanaan Internal --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pendanaan Internal</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pendanaan_internal"
                            value="{{ $penelitianDosen->penelitian->pendanaan_internal }}">
                        <small id="error-pendanaan_internal" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Pendanaan Eksternal --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pendanaan Eksternal</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pendanaan_eksternal"
                            value="{{ $penelitianDosen->penelitian->pendanaan_eksternal }}">
                        <small id="error-pendanaan_eksternal" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Link Penelitian --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Link Penelitian</label>
                    <div class="col-10">
                        <textarea name="link_penelitian" id="link_penelitian" class="form-control summernote">{!! $penelitianDosen->penelitian->link_penelitian !!}</textarea>
                        <small id="error-link_penelitian" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                 {{-- //form updatestatus --}}
                 <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Status Penelitian</label>
                    <div class="col-10">
                        <select name="status" class="form-control" required>
                            <option value="accepted"
                                {{ $penelitianDosen->status == 'accepted' ? 'selected' : '' }}>Accepted
                            </option>
                            <option value="rejected"
                                {{ $penelitianDosen->status == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                </div>

            </div>



            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

<!-- Include Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>
    $(document).ready(function () {
        $('#link_penelitian').summernote({
            placeholder: 'Masukkan link penelitian atau deskripsi',
            tabsize: 2,
            height: 200
        });

        $('#form-edit').validate({
            rules: {
                no_surat_tugas: { required: true },
                judul_penelitian: { required: true },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (res, textStatus, xhr) {
                        if (xhr.status === 200) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            });
                            dataMaster.ajax.reload();
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan!'
                        });

                        if (xhr.responseJSON?.msgField) {
                            $('.error-text').text('');
                            $.each(xhr.responseJSON.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
