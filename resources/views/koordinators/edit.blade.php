<form id="form-edit" action="{{ route('koordinator.update', $mKoordinator->koordinator_id) }}" method="post">
    @csrf
    @method('PUT')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Koordinator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Nama --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="koordinator_nama"
                            value="{{ $mKoordinator->koordinator_nama }}" required>
                        <small id="error-koordinator_nama" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Kode Tugas --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kode Tugas</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="koordinator_kode_tugas"
                            value="{{ $mKoordinator->koordinator_kode_tugas }}" required>
                        <small id="error-koordinator_kode_tugas" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="koordinator_email"
                            value="{{ $mKoordinator->koordinator_email }}" required>
                        <small id="error-koordinator_email" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Level --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Level</label>
                    <div class="col-10">
                        <select class="form-control" name="level_id" required>
                            <option value="">Pilih Level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}"
                                    {{ $mKoordinator->user->level_id == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="form-text text-danger error-text"></small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-edit').validate({
            rules: {
                koordinator_nama: {
                    required: true
                },
                koordinator_kode_tugas: {
                    required: true
                },
                koordinator_email: {
                    required: true,
                    email: true
                },
                level_id: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(res) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        });
                        dataMaster.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                'Terjadi kesalahan!'
                        });

                        if (xhr.responseJSON && xhr.responseJSON.msgField) {
                            $('.error-text').text('');
                            $.each(xhr.responseJSON.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                    }
                });
                return false;
            }
        });
    });
</script>
