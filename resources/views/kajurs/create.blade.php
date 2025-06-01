<form id="form-tambah" action="{{ route('ketua-jurusan.store') }}" method="post">
    @csrf

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Kajur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- NIP Kajur --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIP</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="kajur_nip">
                        <small id="error-kajur_nip" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- NIDN Kajur --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIDN</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="kajur_nidn">
                        <small id="error-kajur_nidn" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Nama Kajur --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Kajur</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="kajur_nama" required>
                        <small id="error-kajur_nama" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Email Kajur --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="kajur_email" required>
                        <small id="error-kajur_email" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Gender Kajur --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Gender</label>
                    <div class="col-10">
                        <select class="form-control" name="kajur_gender" required>
                            <option value="">Pilih Gender</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <small id="error-kajur_gender" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Jurusan --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jurusan</label>
                    <div class="col-10">
                        <select class="form-control" name="kajur_jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="Jurusan Teknologi Informasi">Jurusan Teknologi Informasi</option>
                        </select>
                        <small id="error-kajur_jurusan" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Username --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Username</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="username" required>
                        <small id="error-username" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Password</label>
                    <div class="col-10">
                        <input type="password" class="form-control" name="password" required>
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
                                <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
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
        $('#form-tambah').validate({
            rules: {
                kajur_nama: { required: true },
                kajur_email: { required: true, email: true },
                kajur_gender: { required: true },
                kajur_jurusan: { required: true },
                level_id: { required: true },
                username: { required: true, maxlength: 100 },
                password: { required: true, minlength: 8 }
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
                            dataMaster.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan!'
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
