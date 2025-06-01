@empty($penelitianDosen)
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
                    Data dosen dalam penelitian tidak ditemukan.
                </div>
                <a href="{{ route('penelitian-dosen.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form id="form-delete"
        action="{{ route('penelitian-dosen-koordinator.destroy', $penelitianDosen->id_penelitian_dosen) }}" method="post">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Dosen dari Penelitian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus dosen berikut dari penelitian?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">Nama Dosen</th>
                            <td class="col-8">{{ $penelitianDosen->dosen->dosen_nama ?? 'Tidak diketahui' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Judul Penelitian</th>
                            <td class="col-8">{{ $penelitianDosen->penelitian->judul_penelitian ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">No Surat Tugas</th>
                            <td class="col-8">{{ $penelitianDosen->penelitian->no_surat_tugas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Status</th>
                            <td class="col-8">{{ $penelitianDosen->status }}</td>
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
