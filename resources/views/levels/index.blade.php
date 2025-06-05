@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    {{ $page->title }}
                </h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('management-users/level/create') }}')"
                        class="btn btn-sm btn-success mt-1">Add</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width" id="table_master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Level Code</th>
                                <th>Level Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url) {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        let dataMaster;
        $(document).ready(function() {
            dataMaster = $('#table_master').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('management-users/level/list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'level_kode',
                        className: '',
                    },
                    {
                        data: 'level_nama',
                        className: '',
                    },
                    {
                        data: 'level_id',
                        className: '',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let html = `
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-warning text-white"
                                    onclick="modalAction('{{ url('management-users/level') }}/${data}/edit')"
                                    title="Edit Data">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-danger text-white"
                                    onclick="modalAction('{{ url('management-users/level') }}/${data}/delete')"
                                    title="Hapus Data">
                                    <i class="fa fa-trash"></i>
                                </a>`;
                            return html;
                        }
                    }
                ],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            // custom search: tekan Enter
            $('.dataTables_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode === 13) {
                    dataMaster.search(this.value).draw();
                }
            });
        });
    </script>
@endpush
