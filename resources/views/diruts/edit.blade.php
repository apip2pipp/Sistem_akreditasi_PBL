<form id="form-edit" action="{{ route('direktur-utama.update', $mDirut->dirut_id) }}" method="post">
    @csrf
    @method('PUT')

    <div id="modal-edit" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Dirut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Nama Dirut --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Dirut</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="dirut_nama" value="{{ $mDirut->dirut_nama }}"
                            required>
                        <small id="error-dirut_nama" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- NIP Dirut --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIP</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="dirut_nip" value="{{ $mDirut->dirut_nip }}"
                            required>
                        <small id="error-dirut_nip" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Email Dirut --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="dirut_email" value="{{ $mDirut->dirut_email }}"
                            required>
                        <small id="error-dirut_email" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- username --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Username</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="username"
                            value="{{ $mDirut->user ? $mDirut->user->username : '' }}" required>
                        <small id="error-username" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Password Dirut --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Password</label>
                    <div class="col-10">
                        <input type="password" class="form-control" name="password">
                        <small id="error-password" class="form-text text-danger error-text"></small>
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
                                    {{ $mDirut->user && $mDirut->user->level_id == $level->level_id ? 'selected' : '' }}>
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
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-edit').validate({
            rules: {
                dirut_nama: {
                    required: true
                },
                dirut_nip: {
                    required: true
                },
                dirut_email: {
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
                    success: function(res, textStatus, xhr) {
                        if (xhr.status == 200) {
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
