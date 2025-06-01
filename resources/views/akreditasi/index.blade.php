@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    {{ $page->title }}
                </h3>
            </div>

            <div class="card-body">
                {{-- Form Draft & Final --}}
                <form id="form-akreditasi" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- judul_ppepp --}}
                    <div class="form-group row">
                        <label for="judul_ppepp" class="col-sm-2 col-form-label">Judul PPEPP</label>
                        <div class="col-sm-7">
                            <input type="text" name="judul_ppepp" id="judul_ppepp" class="form-control" required>
                        </div>
                    </div>

                    {{-- Penetapan --}}
                    <div class="form-group row">
                        <label for="penetapan" class="col-sm-2 col-form-label">Penetapan</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="penetapan" id="penetapan" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_penetapan">Upload Gambar</label>
                                <input type="file" name="gambar_penetapan[]" id="gambar_penetapan" multiple
                                    class="form-control-file" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    {{-- Pelaksanaan --}}
                    <div class="form-group row">
                        <label for="pelaksanaan" class="col-sm-2 col-form-label">Pelaksanaan</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="pelaksanaan" id="pelaksanaan" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_pelaksanaan">Upload Gambar</label>
                                <input type="file" name="gambar_pelaksanaan[]" id="gambar_pelaksanaan" multiple
                                    class="form-control-file" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    {{-- Evaluasi --}}
                    <div class="form-group row">
                        <label for="evaluasi" class="col-sm-2 col-form-label">Evaluasi</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="evaluasi" id="evaluasi" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_evaluasi">Upload Gambar</label>
                                <input type="file" name="gambar_evaluasi[]" id="gambar_evaluasi" multiple
                                    class="form-control-file" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    {{-- Pengendalian --}}
                    <div class="form-group row">
                        <label for="pengendalian" class="col-sm-2 col-form-label">Pengendalian</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="pengendalian" id="pengendalian" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_pengendalian">Upload Gambar</label>
                                <input type="file" name="gambar_pengendalian[]" id="gambar_pengendalian" multiple
                                    class="form-control-file" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    {{-- Peningkatan --}}
                    <div class="form-group row">
                        <label for="peningkatan" class="col-sm-2 col-form-label">Peningkatan</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="peningkatan" id="peningkatan" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_peningkatan">Upload Gambar</label>
                                <input type="file" name="gambar_peningkatan[]" id="gambar_peningkatan" multiple
                                    class="form-control-file" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    {{-- Tombol draft dan final --}}
                    <button type="submit" id="btn-draft" class="btn btn-primary">Simpan Draft</button>
                </form>


                <hr>

                {{-- Tabel DataTables --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table-akreditasi" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Akreditasi</th>
                                <th>Status</th>
                                <th>File PDF</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
    <style>
        .form-control-file {
            height: 200px;
            overflow-y: auto;
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#penetapan, #pelaksanaan, #evaluasi, #pengendalian, #peningkatan').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview']]
                ]
            });
            // URL route dari Laravel ke JS
            const slug = "{{ $kriteria->route }}";
            const url = "{{ url('akreditasi/list') }}/" + slug;
            console.log(slug);
            let lastSavedAkreditasiId = null;

            // Setup DataTables
            let table = $('#table-akreditasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'akreditasi_id',
                        name: 'akreditasi_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'file_akreditasi',
                        name: 'file_akreditasi',
                        render: function(data) {
                            if (data) {
                                return `<a href="/storage/${data}" target="_blank" class="btn btn-sm btn-info">Lihat PDF</a>`;
                            }
                            return '-';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'akreditasi_id',
                        render: function(data, type, row) {
                            let editdraft = '{{ route('akreditasi.editDraft', '') }}/' + data;
                            return ` <a href="${editdraft}" class="btn btn-sm btn-warning">Edit</a>
                            <button class="btn btn-sm btn-success btn-finalize" data-id="${data}">Finalisasi</button>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Submit form draft (POST ke draft route)
            $('#form-akreditasi').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('akreditasi.draft', '') }}/" + slug,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Draft berhasil disimpan!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        table.ajax.reload();

                        form.reset();

                    },

                    error: function(xhr) {
                        alert('Gagal menyimpan draft: ' + xhr.responseJSON?.message ||
                            'Server error');
                    }
                });
            });

            // Tombol finalisasi dari baris tabel
            $('#table-akreditasi tbody').on('click', '.btn-finalize', function() {
                let id = $(this).data('id');
                if (!confirm('Finalisasi akreditasi ini?')) return;

                $.ajax({
                    url: "{{ route('akreditasi.final', '') }}/" + id,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire('Sukses', 'Finalisasi berhasil!', 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal finalisasi: ' + xhr.responseJSON?.message ||
                            'Server error');
                    }
                });
            });

        });
    </script>
@endpush
