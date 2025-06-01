@empty($mKoordinator)
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
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ route('level.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form id="form-delete" action="{{ route('koordinator.destroy', $mKoordinator->koordinator_id) }}" method="post">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini ?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Koordinator</th>
                            <td class="col-9">{{ $mKoordinator->koordinator_nama }}</td>
                        </tr>

                        <tr>
                            <th class="text-right col-3">Email Level</th>
                            <td class="col-9">{{ $mKoordinator->koordinator_email }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kode Tugas</th>
                            <td class="col-9">{{ $mKoordinator->koordinator_kode_tugas }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#form-delete').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: this.action,
                    type: 'POST',
                    data: $(this).serialize(),
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
                            title: 'Gagal menghapus',
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                'Terjadi kesalahan saat menghapus data.'
                        });
                    }
                });
            });
        });
    </script>
@endempty
