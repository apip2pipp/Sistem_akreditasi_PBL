<form id="form-import" action="{{ url('management-users/dosen/import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Level Dropdown --}}
                <div class="form-group">
                    <label for="level_id">Pilih Level</label>
                    <select name="level_id" class="form-control" required>
                        <option value="">-- Pilih Level --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- File Excel --}}
                <div class="form-group">
                    <label for="file">Pilih File Excel (.xlsx / .xls)</label>
                    <input type="file" name="file" class="form-control-file" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#form-import').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#myModal').modal('hide');
                Swal.fire('Sukses', res.message, 'success');
                // Check if there are any failed rows
                if (res.failed_rows && res.failed_rows.length > 0) {
                    // Display failed rows in a modal or console log
                    console.log('Failed Rows:', res.failed_rows);
                    Swal.fire({
                        title: 'Beberapa data gagal diimport!',
                        html: '<pre>' + JSON.stringify(res.failed_rows, null, 2) + '</pre>',
                        icon: 'error'
                    });
                }
                dataMaster.ajax.reload();
            },
            error: function(err) {
                Swal.fire('Error', err.responseJSON.message, 'error');
            }
        });
    });
</script>
