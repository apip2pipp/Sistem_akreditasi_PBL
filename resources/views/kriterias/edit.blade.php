<form id="form-edit" action="{{ route('kriteria.update', $mKriteria->kriteria_id) }}" method="post">
    @csrf
    @method('PUT')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Criteria Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Nama Kriteria --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Name Criteria</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="nama_kriteria"
                            value="{{ $mKriteria->nama_kriteria }}" required>
                        <small id="error-nama_kriteria" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                {{-- URL --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">URL</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="route" value="{{ $mKriteria->route }}">
                        <small id="error-route" class="form-text text-danger error-text"></small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-edit').validate({
            rules: {
                nama_kriteria: {
                    required: true,
                    maxlength: 255
                },
                route: {
                    maxlength: 255
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(res) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Succes',
                            text: res.message
                        });
                        dataMaster.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error has occurred',
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                'An error has occurred!'
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
            }
        });
    });
</script>
