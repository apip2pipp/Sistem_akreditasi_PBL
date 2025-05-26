<form id="form-edit" action="{{ route('dosen.update', $mDosen->dosen_id) }}" method="post">
    @csrf
    @method('PUT')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- NIP Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIP</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="dosen_nip" value="{{ old('dosen_nip', $mDosen->dosen_nip) }}" required>
                        <small id="error-dosen_nip" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Nama Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Dosen</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="dosen_nama" value="{{ old('dosen_nama', $mDosen->dosen_nama) }}" required>
                        <small id="error-dosen_nama" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- NIDN Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIDN</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="dosen_nidn" value="{{ old('dosen_nidn', $mDosen->dosen_nidn) }}">
                        <small id="error-dosen_nidn" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Email Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="dosen_email" value="{{ old('dosen_email', $mDosen->dosen_email) }}" required>
                        <small id="error-dosen_email" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Gender Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Gender</label>
                    <div class="col-10">
                        <select class="form-control" name="dosen_gender" required>
                            <option value="L" {{ old('dosen_gender', $mDosen->dosen_gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('dosen_gender', $mDosen->dosen_gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <small id="error-dosen_gender" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Username Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Username</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="username" value="{{ old('username', $mDosen->user->username) }}" required>
                        <small id="error-username" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Password Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Password</label>
                    <div class="col-10">
                        <input type="password" class="form-control" name="password">
                        <small id="error-password" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Level Dosen --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Level</label>
                    <div class="col-10">
                        <select class="form-control" name="level_id" required>
                            <option value="">Pilih Level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}" {{ old('level_id', $mDosen->user->level_id) == $level->level_id ? 'selected' : '' }}>{{ $level->level_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="form-text text-danger error-text"></small>
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
        $('#form-edit').validate({
            rules: {
                dosen_nip: {
                    required: true,
                    minlength: 3
                },
                dosen_nama: {
                    required: true
                },
                dosen_email: {
                    required: true,
                    email: true
                },
                dosen_gender: {
                    required: true
                },
                level_id: {
                    required: true
                },
                username: {
                    required: true,
                    maxlength: 100
                },
                password: {
                    minlength: 8
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res, textStatus, xhr) {
                        if (xhr.status == 200) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            });

                            // Update table data or reload it
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
