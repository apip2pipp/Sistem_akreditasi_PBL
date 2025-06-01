@empty($mDosen)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan !!!</h5>
                    Data dosen yang Anda cari tidak ditemukan
                </div>
                <a href="{{ route('dosen.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form id="form-delete" action="{{ route('dosen.destroy', $mDosen->dosen_id) }}" method="post">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data dosen berikut?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">NIP</th>
                            <td class="col-9">{{ $mDosen->dosen_nip }}</td>
                        </tr>

                        <tr>
                            <th class="text-right col-3">Nama Dosen</th>
                            <td class="col-9">{{ $mDosen->dosen_nama }}</td>
                        </tr>

                        <tr>
                            <th class="text-right col-3">Email</th>
                            <td class="col-9">{{ $mDosen->dosen_email }}</td>
                        </tr>

                        <tr>
                            <th class="text-right col-3">Level</th>
                            <td class="col-9">{{ $mDosen->user ? $mDosen->user->level->level_nama : 'Tidak ada level' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#form-delete').validate({
                rules: {},
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

                                // Reload or refresh the table
                                dataMaster.ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
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
                errorPlacement: (error, element) => {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: (element, errorClass, validClass) => {
                    $(element).addClass('is-invalid');
                },
                unhighlight: (element, errorClass, validClass) => {
                    $(element).removeClass('is-invalid');
                }
            })
        });
    </script>
@endempty
