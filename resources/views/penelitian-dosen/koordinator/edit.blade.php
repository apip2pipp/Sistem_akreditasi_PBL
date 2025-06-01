<form id="form-edit" action="{{ route('penelitian-dosen-koordinator.update', $penelitianDosen->id_penelitian_dosen) }}"
    method="post">
    @csrf
    @method('PUT')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Penelitian Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Dosen --}}
                <div class="form-group required row mb-2">
                    <label class="col-2 control-label col-form-label">Dosen</label>
                    <div class="col-10">
                        <select id="dosen_id" name="dosen_id" class="form-control select2">
                            @foreach ($dataDosen as $dosen)
                                <option value="{{ $dosen->dosen_id }}"
                                    @if (in_array($dosen->dosen_id, $selectedDosenIds)) selected @endif>
                                    {{ $dosen->dosen_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-dosen_id" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- No Surat Tugas --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No Surat Tugas</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="no_surat_tugas"
                            value="{{ $penelitian->no_surat_tugas }}" required>
                        <small id="error-no_surat_tugas" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Judul Penelitian --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Judul Penelitian</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="judul_penelitian"
                            value="{{ $penelitian->judul_penelitian }}" required>
                        <small id="error-judul_penelitian" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Pendanaan Internal --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pendanaan Internal</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pendanaan_internal"
                            value="{{ $penelitian->pendanaan_internal }}">
                        <small id="error-pendanaan_internal" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Pendanaan Eksternal --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pendanaan Eksternal</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pendanaan_eksternal"
                            value="{{ $penelitian->pendanaan_eksternal }}">
                        <small id="error-pendanaan_eksternal" class="form-text text-danger error-text"></small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#dosen_id').select2({
            placeholder: "Pilih satu atau lebih Dosen",
            allowClear: true,
        });

        $('#form-edit').validate({
            rules: {
                'dosen_id[]': {
                    required: true
                },
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
                                title: 'Berhasil',
                                text: res.message
                            });

                            dataMaster.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan!'
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
