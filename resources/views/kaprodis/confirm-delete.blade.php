@empty($mKaprodi)
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
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ route('kaprodi.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form id="form-delete" action="{{ route('kaprodi.destroy', $mKaprodi->kaprodi_id) }}" method="post">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Kaprodi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data Kaprodi berikut ini?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama</th>
                            <td class="col-9">{{ $mKaprodi->kaprodi_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">NIP</th>
                            <td class="col-9">{{ $mKaprodi->kaprodi_nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">NIDN</th>
                            <td class="col-9">{{ $mKaprodi->kaprodi_nidn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Email</th>
                            <td class="col-9">{{ $mKaprodi->kaprodi_email }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Program Studi</th>
                            <td class="col-9">{{ $mKaprodi->kaprodi_prodi }}</td>
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
                                text: xhr.responseJSON ? xhr.responseJSON.message :
                                    'Terjadi kesalahan!'
                            });
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
@endempty
