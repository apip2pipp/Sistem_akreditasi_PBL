@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    {{ $page->title ?? 'Daftar Penelitian Dosen' }}
                </h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('penelitian-dosen/create') }}')"
                        class="btn btn-sm btn-success mt-1">Tambah</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width" id="table_master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dosen</th>
                                <th>Judul Penelitian</th>
                                <th>Status</th>
                                <th>#</th>
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
                    url: "{{ route('penelitian-dosen.list') }}",
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
                        data: 'dosen.dosen_nama',
                        className: '',
                        defaultContent: '-',
                    },
                    {
                        data: 'penelitian.judul_penelitian',
                        className: '',
                        defaultContent: '-',
                    },
                    {
                        data: 'status',
                        className: '',
                        render: function(data, type, row) {
                            var statusText = data ? data : '-';
                            var statusClass = '';

                            // Apply different classes based on status value
                            switch (data) {
                                case 'pending':
                                    statusClass = 'badge badge-warning'; // Yellow
                                    break;
                                case 'accepted':
                                    statusClass = 'badge badge-success'; // Green
                                    break;
                                case 'rejected':
                                    statusClass = 'badge badge-danger'; // Red
                                    break;
                                default:
                                    statusClass = 'badge badge-secondary'; // Default gray
                                    break;
                            }

                            // Return the status text wrapped in a span with the correct class
                            return `<span class="${statusClass}">${statusText}</span>`;
                        }
                    },
                    {
                        data: 'id_penelitian_dosen',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            let editUrl = `{{ url('penelitian-dosen') }}/${data}/edit`;
                            let showUrl = `{{ url('penelitian-dosen') }}/${data}`;
                            let deleteUrl = `{{ url('penelitian-dosen') }}/${data}/delete`;

                            return `
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-warning text-white"
                                    onclick="modalAction('${editUrl}')"
                                    title="Edit Data">
                                    <i class="fa fa-edit"></i>
                                </a> 
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-info text-white"
                                    onclick="modalAction('${showUrl}')"
                                    title="Detail Data">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-danger text-white"
                                    onclick="modalAction('${deleteUrl}')"
                                    title="Hapus Data">
                                    <i class="fa fa-trash"></i>
                                </a>
                            `;
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
