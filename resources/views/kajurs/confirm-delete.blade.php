@empty($mKajur)
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
                    Data Kajur yang Anda cari tidak ditemukan
                </div>
                <a href="{{ route('kajur.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form id="form-delete" action="{{ route('ketua-jurusan.destroy', $mKajur->kajur_id) }}" method="post">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Kajur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data Kajur berikut?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">NIP</th>
                            <td class="col-9">{{ $mKajur->kajur_nip }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama</th>
                            <td class="col-9">{{ $mKajur->kajur_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Email</th>
                            <td class="col-9">{{ $mKajur->kajur_email }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Level</th>
                            <td class="col-9">
                                {{ $mKajur->user && $mKajur->user->level ? $mKajur->user->level->level_nama : 'Tidak ada level' }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: (error, element) => {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: (element) => {
                    $(element).addClass('is-invalid');
                },
                unhighlight: (element) => {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
