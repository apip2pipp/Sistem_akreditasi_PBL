<form id="form-edit" action="{{ route('user.update', $mUser->user_id) }}" method="post">
    @csrf
    @method('PUT')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Username --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Username</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="username"
                            value="{{ old('username', $mUser->username) }}" required>
                        <small id="error-username" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $mUser->email) }}" required>
                        <small id="error-email" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Name --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Name</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $mUser->name) }}" required>
                        <small id="error-name" class="form-text text-danger error-text"></small>
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
                                    {{ $mUser->level_id == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Password Baru (Opsional) --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">New Password</label>
                    <div class="col-10">
                        <input type="password" class="form-control" name="password"
                            placeholder="Kosongkan jika tidak ingin diubah">
                        <small id="error-password" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Confirmation Password</label>
                    <div class="col-10">
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Ulangi password baru">
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

<script>
    $(document).ready(function() {
        $('#form-edit').validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                name: {
                    required: true
                },
                password: {
                    minlength: 6
                },
                password_confirmation: {
                    equalTo: '[name="password"]'
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
