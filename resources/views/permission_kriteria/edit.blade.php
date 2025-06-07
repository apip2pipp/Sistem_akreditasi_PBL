<form id="form-edit" action="{{ route('permission-kriteria.update', $koordinator->koordinator_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div id="modal-edit" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Permission Koordinator: {{ $koordinator->koordinator_nama }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Checklist Kriteria --}}
                <div class="form-group">
                    <label class="font-weight-bold mb-2">Criteria Access Rights</label>

                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        @forelse ($kriteria as $item)
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="kriteria_{{ $item->kriteria_id }}"
                                    name="kriteria[]" value="{{ $item->kriteria_id }}"
                                    {{ $koordinator->permissions->where('kriteria_id', $item->kriteria_id)->where('status', true)->count() ? 'checked' : '' }}>
                                <label class="form-check-label" for="kriteria_{{ $item->kriteria_id }}">
                                    {{ $item->nama_kriteria }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted">No criteria available yet.</p>
                        @endforelse
                    </div>

                    <small id="error-kriteria" class="form-text text-danger error-text"></small>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#form-edit').validate({
            rules: {
                'kriteria[]': {
                    required: true
                }
            },
            messages: {
                'kriteria[]': {
                    required: 'Select at least one criteria.'
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
                                title: 'Success',
                                text: res.message ??
                                    'Permission updated successfully!'
                            });
                            dataMaster.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON?.message ??
                                'An Error Occurred!'
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
