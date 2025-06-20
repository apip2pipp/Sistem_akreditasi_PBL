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
                        <label for="judul_ppepp" class="col-sm-2 col-form-label">Title PPEPP</label>
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
                                <label for="gambar_penetapan">Upload Supporting Documents</label>
                                <input type="file" name="gambar_penetapan[]" id="gambar_penetapan" multiple
                                    class="form-control-file" accept="image/*,application/pdf" />
                            </div>
                        </div>
                    </div>

                    {{-- Pelaksanaan --}}
                    <div class="form-group row">
                        <label for="pelaksanaan" class="col-sm-2 col-form-label">Pelaksanaan</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="pelaksanaan" id="pelaksanaan" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_pelaksanaan">Upload Supporting Documents</label>
                                <input type="file" name="gambar_pelaksanaan[]" id="gambar_pelaksanaan" multiple
                                    class="form-control-file" accept="image/*,application/pdf" />
                            </div>
                        </div>
                    </div>

                    {{-- Evaluasi --}}
                    <div class="form-group row">
                        <label for="evaluasi" class="col-sm-2 col-form-label">Evaluasi</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="evaluasi" id="evaluasi" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_evaluasi">Upload Supporting Documents</label>
                                <input type="file" name="gambar_evaluasi[]" id="gambar_evaluasi" multiple
                                    class="form-control-file" accept="image/*,application/pdf" />
                            </div>
                        </div>
                    </div>

                    {{-- Pengendalian --}}
                    <div class="form-group row">
                        <label for="pengendalian" class="col-sm-2 col-form-label">Pengendalian</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="pengendalian" id="pengendalian" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_pengendalian">Upload Supporting Documents</label>
                                <input type="file" name="gambar_pengendalian[]" id="gambar_pengendalian" multiple
                                    class="form-control-file" accept="image/*,application/pdf" />
                            </div>
                        </div>
                    </div>

                    {{-- Peningkatan --}}
                    <div class="form-group row">
                        <label for="peningkatan" class="col-sm-2 col-form-label">Peningkatan</label>
                        <div class="col-sm-10 d-flex">
                            <textarea name="peningkatan" id="peningkatan" class="form-control" required></textarea>
                            <div class="ml-3" style="width: 200px; border: 0.5px solid #0c0c0c">
                                <label for="gambar_peningkatan">Upload Supporting Documents</label>
                                <input type="file" name="gambar_peningkatan[]" id="gambar_peningkatan" multiple
                                    class="form-control-file" accept="image/*,application/pdf" />
                            </div>
                        </div>
                    </div>

                    {{-- Tombol draft dan final --}}
                    <button type="submit" id="btn-draft" class="btn btn-primary">Save Draft</button>
                </form>
                <!-- Loading Overlay -->
                <div id="loading-overlay">
                    <div>
                        <div class="spinner-border text-light" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="ml-2">Uploading... Please wait</span>
                    </div>
                </div>


                <hr>

                {{-- Tabel DataTables --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table-akreditasi" style="width:100%">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Title PPEPP</th>
                                <th>File PDF</th>
                                <th>Status File</th>
                                <th>Action</th>
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

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.5rem;
        }

        #loading-overlay.active {
            display: flex;
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
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'akreditasi.judul_ppepp', // Correct path to access the judul_ppepp field
                        name: 'akreditasi.judul_ppepp'
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
                        data: 'statusFile',
                        name: 'statusFile',
                        render: function(data) {
                            // Draft, Final, Revisi, Validation
                            if (data == 'Draft') {
                                return `<span class="badge badge-warning">Draft</span>`;
                            } else if (data == 'Final') {
                                return `<span class="badge badge-info">Final</span>`;
                            } else if (data == 'Revisi') {
                                return `<span class="badge badge-danger">Revisi</span>`;
                            } else if (data == 'Validation') {
                                return `<span class="badge badge-success">Validation</span>`;
                            }
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'akreditasi_id',
                        name: 'akreditasi_id',
                        render: function(data, type, row) {
                            let editdraft = '{{ route('akreditasi.editDraft', '') }}/' + data;
                            let revisi = '{{ route('akreditasi.revisiDraft', '') }}/' + data;
                            let showdraft = '{{ route('akreditasi.showDraft', '') }}/' + data;

                            let status = row.statusFile; // Mengambil status dari row

                            // Tampilkan tombol 'Revisi' hanya jika statusnya 'revisi'
                            let revisiBtn = '';
                            if (status == 'Revisi') {
                                revisiBtn =
                                    `<a href="${revisi}" class="btn btn-sm btn-danger">Revisi</a>`;
                            }

                            let status2 = row.statusFile; // Mengambil status dari row
                            let finalisasiBtn = '';
                            if (status2 == 'Draft') {
                                finalisasiBtn =
                                    `<button class="btn btn-sm btn-success btn-finalize" data-id="${data}">Finalisasi</button>`;
                            }


                            return `
                                <a href="${editdraft}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="${showdraft}" class="btn btn-sm btn-info">Lihat</a>
                                ${revisiBtn} <!-- Hanya tampilkan jika status revisi -->
                                ${finalisasiBtn} <!-- Hanya tampilkan jika status draft -->
                            `;
                        },
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Submit form draft (POST ke draft route)
            $('#form-akreditasi').on('submit', function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Tampilkan loading overlay
                $('#loading-overlay').addClass('active');

                $.ajax({
                    url: "{{ route('akreditasi.draft', '') }}/" + slug,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Draft successfully saved!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        table.ajax.reload();
                        setTimeout(function() {
                            location.reload(); // Memuat ulang halaman
                        }, 2000);
                    },
                    error: function(xhr) {
                        alert('Gagal menyimpan draft: ' + (xhr.responseJSON?.message ||
                            'Server error'));
                    },
                    complete: function() {
                        // Sembunyikan loading overlay apapun hasilnya
                        $('#loading-overlay').removeClass('active');
                    }
                });
            });



            // Tombol finalisasi dari baris tabel
            $('#table-akreditasi tbody').on('click', '.btn-finalize', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure you want to finalize?',
                    text: 'Once finalized, the data cannot be changed again.!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, finalization!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('akreditasi.final', '') }}/" + id,
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire('Sukses!', 'Finalization successful!',
                                    'success');
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                // Ensure that the error key is accessed directly
                                let errorMessage = xhr.responseJSON && xhr.responseJSON
                                    .error ?
                                    xhr.responseJSON.error :
                                    'Server error';

                                Swal.fire('Erorr', errorMessage, 'error');
                            }
                        });
                    }
                });
            });


        });
    </script>
@endpush
