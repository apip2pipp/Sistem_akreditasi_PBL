@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    Edit Accreditation Draft
                </h3>
            </div>
            <div class="card-body">
                @php use Illuminate\Support\Str; @endphp

                <form action="{{ route('akreditasi.updateDraft', $akreditasi->id_akreditasi) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Judul PPEPP --}}
                    <div class="form-group row">
                        <label for="judul_ppepp" class="col-sm-2 col-form-label">Title of PPEPP</label>
                        <div class="col-sm-7">
                            <input type="text" name="judul_ppepp" id="judul_ppepp" class="form-control"
                                value="{{ $akreditasi->judul_ppepp }}" required>
                        </div>
                    </div>

                    {{-- ================= PENETAPAN ================= --}}
                    <div class="form-group">
                        <label for="penetapan">Penetapan</label>
                        <textarea name="penetapan" id="penetapan" class="form-control summernote" rows="4" required>{!! $akreditasi->penetapan->penetapan !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Document Penetapan</label>
                        <div class="row">
                            @foreach ($akreditasi->penetapan->gambarPenetapan as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_penetapan) }}"
                                            class="img-thumbnail">
                                    @elseif ($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_penetapan) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            📄 See PDF
                                        </a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_penetapan[]"
                                            value="{{ $gambar->id_gambar_penetapan }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gambar_penetapan">Add Document Penetapan</label>
                        <input type="file" name="gambar_penetapan[]" class="form-control" multiple>
                    </div>

                    {{-- ================= PELAKSANAAN ================= --}}
                    <div class="form-group">
                        <label for="pelaksanaan">Pelaksanaan</label>
                        <textarea name="pelaksanaan" id="pelaksanaan" class="form-control summernote" rows="4" required>{!! $akreditasi->pelaksanaan->pelaksanaan !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Document Pelaksanaan</label>
                        <div class="row">
                            @foreach ($akreditasi->pelaksanaan->gambarPelaksanaan as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_pelaksanaan) }}"
                                            class="img-thumbnail">
                                    @elseif ($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_pelaksanaan) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            📄 See PDF
                                        </a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_pelaksanaan[]"
                                            value="{{ $gambar->id_gambar_pelaksanaan }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gambar_pelaksanaan">Add Document Pelaksanaan</label>
                        <input type="file" name="gambar_pelaksanaan[]" class="form-control" multiple>
                    </div>

                    {{-- ================= EVALUASI ================= --}}
                    <div class="form-group">
                        <label for="evaluasi">Evaluasi</label>
                        <textarea name="evaluasi" id="evaluasi" class="form-control summernote" rows="4" required>{!! $akreditasi->evaluasi->evaluasi !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Document Evaluasi</label>
                        <div class="row">
                            @foreach ($akreditasi->evaluasi->gambarEvaluasi as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_evaluasi) }}" class="img-thumbnail">
                                    @elseif ($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_evaluasi) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            📄 See PDF
                                        </a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_evaluasi[]"
                                            value="{{ $gambar->id_gambar_evaluasi }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gambar_evaluasi">Add Document Evaluasi</label>
                        <input type="file" name="gambar_evaluasi[]" class="form-control" multiple>
                    </div>

                    {{-- ================= PENGENDALIAN ================= --}}
                    <div class="form-group">
                        <label for="pengendalian">Pengendalian</label>
                        <textarea name="pengendalian" id="pengendalian" class="form-control summernote" rows="4" required>{!! $akreditasi->pengendalian->pengendalian !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Document Pengendalian</label>
                        <div class="row">
                            @foreach ($akreditasi->pengendalian->gambarPengendalian as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_pengendalian) }}"
                                            class="img-thumbnail">
                                    @elseif ($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_pengendalian) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            📄 See PDF
                                        </a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_pengendalian[]"
                                            value="{{ $gambar->id_gambar_pengendalian }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gambar_pengendalian">Add Document Pengendalian</label>
                        <input type="file" name="gambar_pengendalian[]" class="form-control" multiple>
                    </div>

                    {{-- ================= PENINGKATAN ================= --}}
                    <div class="form-group">
                        <label for="peningkatan">Peningkatan</label>
                        <textarea name="peningkatan" id="peningkatan" class="form-control summernote" rows="4" required>{!! $akreditasi->peningkatan->peningkatan !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Document Peningkatan</label>
                        <div class="row">
                            @foreach ($akreditasi->peningkatan->gambarPeningkatan as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_peningkatan) }}"
                                            class="img-thumbnail">
                                    @elseif ($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_peningkatan) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            📄 See PDF
                                        </a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_peningkatan[]"
                                            value="{{ $gambar->id_gambar_peningkatan }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gambar_peningkatan">Add Document Peningkatan</label>
                        <input type="file" name="gambar_peningkatan[]" class="form-control" multiple>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="form-group text-right">
                        <a href="{{ route('akreditasi.index', ['slug' => $akreditasi->kriteria->route]) }}"
                            class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button id="btn-generate-pdf" type="button">Generate PDF</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('css')
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

            // Handle form submission
            $('#btn-generate-pdf').click(function(event) {
                event.preventDefault(); // cegah reload/submit form

                $.ajax({
                    url: '{{ route('akreditasi.generate.pdf.update', $akreditasi->id_akreditasi) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successful',
                            text: 'The PDF has been successfully created.'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                'An error occurred while generating the PDF.'
                        });
                    }
                });
            });


        });
    </script>
@endpush
