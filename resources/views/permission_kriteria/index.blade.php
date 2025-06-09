@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    Permission Coordinator List
                </h3>
                {{-- Tidak ada tombol tambah karena ini cuma list permission --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width" id="table_master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Coordinator</th>
                                <th>Access Permission (Criteria)</th>
                                <th>Action</th>
                                {{-- Kalau mau tombol aksi, bisa ditambah di sini --}}
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    {{-- Tambahkan CSS khusus kalau perlu --}}
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
                    url: "{{ route('permission-kriteria.list') }}",
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
                        searchable: false
                    },
                    {
                        data: 'koordinator_nama',
                        className: ''
                    },
                    {
                        data: 'hak_permission',
                        className: ''
                    },
                    {
                        data: 'koordinator_id',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `
                            <a href="javascript:void(0)" 
                                    class="btn btn-xs btn-warning text-white"
                                    onclick="modalAction('{{ url('permission-kriteria/give-permissions/') }}/${data}')"
                                    title="Edit Data">
                                    <i class="fa fa-edit"></i>
                                </a>`;
                        }
                    }
                ],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            // Tekan enter untuk search
            $('.dataTables_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode === 13) {
                    dataMaster.search(this.value).draw();
                }
            });
        });
    </script>
@endpush
