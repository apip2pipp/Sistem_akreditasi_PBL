@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    Edit Draft Akreditasi
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('akreditasi.updateDraft', $akreditasi->id_akreditasi) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- judul_ppepp --}}
                    <div class="form-group row">
                        <label for="judul_ppepp" class="col-sm-2 col-form-label">Judul PPEPP</label>
                        <div class="col-sm-7">
                            <input type="text" name="judul_ppepp" id="judul_ppepp" class="form-control"
                                value="{{ $fileAkreditasi->judul_ppepp }}" required>
                        </div>
                    </div>
                    @foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian)
                        <div class="form-group">
                            <label for="{{ $bagian }}">{{ ucfirst($bagian) }}</label>
                            <textarea name="{{ $bagian }}" id="{{ $bagian }}" class="form-control" rows="4" required>{{ $akreditasi->$bagian->$bagian }}</textarea>
                        </div>

                        {{-- Gambar Lama --}}
                        <div class="form-group">
                            <label>Gambar {{ ucfirst($bagian) }}</label>
                            <div class="row">
                                @php
                                    $gambarCollection = $akreditasi->$bagian->{'gambar' . ucfirst($bagian)};
                                    $fieldName = 'hapus_gambar_' . $bagian;
                                    $gambarField = 'gambar_' . $bagian;
                                    // dd($gambarField);
                                @endphp

                                @foreach ($gambarCollection as $gambar)
                                @php
                                    $gambarId = $gambar->{'id_gambar_' . $bagian};
                                    // dd($gambarId);
                                @endphp
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset('storage/' . $gambar->$gambarField) }}" class="img-thumbnail">
                                        <div class="form-check mt-1">
                                            <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $gambarId }}" class="form-check-input">
                                            <label class="form-check-label text-danger">Hapus</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tambah Gambar Baru --}}
                        <div class="form-group">
                            <label for="gambar_{{ $bagian }}">Tambah Gambar {{ ucfirst($bagian) }}</label>
                            <input type="file" name="gambar_{{ $bagian }}[]" class="form-control" multiple>
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maks 2MB per file.</small>
                        </div>
                    @endforeach

                    <div class="form-group text-right">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
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
        });
    </script>
@endpush
