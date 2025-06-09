@empty($mKriteria)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Errors!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Errors !!!</h5>
                    The data you are looking for was not found.
                </div>
                <a href="{{ route('kriteria.index') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <form id="form-delete" action="{{ route('kriteria.destroy', $mKriteria->kriteria_id) }}" method="post">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Confirmation !!!</h5>
                        Do you want to delete the following data?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Name Criteria</th>
                            <td class="col-9">{{ $mKriteria->nama_kriteria }}</td>
                        </tr>

                        <tr>
                            <th class="text-right col-3">Route</th>
                            <td class="col-9">{{ $mKriteria->route }}</td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
                            title: 'Success',
                            text: res.message
                        });
                        dataMaster.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to delete',
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                'An error occurred while deleting data.'
                        });
                    }
                });
            });
        });
    </script>
@endempty
