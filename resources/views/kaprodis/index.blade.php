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
                    {{-- //Tambah --}}
                    <button onclick="modalAction('{{ url('management-users/kaprodi/create') }}')"
                        class="btn btn-sm btn-success mt-1">Tambah</button>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="kaprodi_prodi" id="kaprodi_prodi" class="form-control">
                                <option value="">- Semua -</option>
                                <option value="D-IV Teknik Informatika">D-IV Teknik Informatika</option>
                                <option value="D-IV Sistem Informasi Bisnis">D-IV Sistem Informasi Bisnis</option>
                                <option value="D-II Pengembangan Perangkat Lunak">D-II Pengembangan Perangkat Lunak</option>
                            </select>
                            <small class="form-text text-muted">Program Studi</small>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm" id="table_master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kaprodi</th>
                                <th>Prodi</th>
                                <th>Email</th>
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
    <style>
        th.sorting_disabled::before,
        th.sorting_disabled::after {
            display: none !important;
        }
    </style>
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
                    url: "{{ route('kaprodi.list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d.kaprodi_prodi = $('#kaprodi_prodi').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kaprodi_nama',
                        className: ''
                    },
                    {
                        data: 'kaprodi_prodi',
                        className: ''
                    },
                    {
                        data: 'kaprodi_email',
                        className: ''
                    },
                    {
                        data: 'kaprodi_id',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let html = `
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-warning text-white"
                                    onclick="modalAction('{{ url('management-users/kaprodi') }}/${data}/edit')"
                                    title="Edit Data">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn btn-xs btn-danger text-white"
                                    onclick="modalAction('{{ url('management-users/kaprodi') }}/${data}/delete')"
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

            $('#kaprodi_prodi').change(function() {
                dataMaster.draw();
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
