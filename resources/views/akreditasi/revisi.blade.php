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
                <!-- Embed PDF Akreditasi -->
                <embed src="{{ url('storage/' . $fileAkreditasi->file_akreditasi) }}" type="application/pdf" width="100%"
                    height="600px">

                <!-- Section for Comments and Status -->
                <div class="mt-4">
                    <h4>Status dan Komentar</h4>

                    <!-- Show Current Status -->
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if ($akreditasi->status == 'draft')
                            <span class="badge badge-warning">Draft</span>
                        @elseif($akreditasi->status == 'final')
                            <span class="badge badge-info">Final</span>
                        @elseif($akreditasi->status == 'revisi')
                            <span class="badge badge-danger">Revisi</span>
                        @elseif($akreditasi->status == 'selesai')
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </div>

                    <!-- Display Comments -->
                    <h5>Daftar Komentar</h5>
                    <div class="list-group">
                        @foreach ($showstatusandkomen as $komen)
                            {{-- kaprodi --}}
                            @if ($komen->kaprodi)
                                <div class="list-group-item">
                                    <strong>{{ $komen->kaprodi->name ?? '-' }} <span
                                            class="text-muted">({{ $komen->tanggal_waktu_kaprodi ? $komen->tanggal_waktu_kaprodi->diffForHumans() : '-' }})</span>
                                        @if ($komen->status_kaprodi == 'Pending')
                                            <span class="badge badge-warning">Draft</span>
                                        @elseif($komen->status_kaprodi == 'Ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($komen->status_kaprodi == 'Disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @endif
                                    </strong>
                                    <p>{!! $komen->komentar_kaprodi ?? '-' !!}</p>
                                </div>
                            @endif
                            @if ($komen->kajur)
                                {{-- kajur --}}
                                <div class="list-group-item">
                                    <strong>{{ $komen->kajur->name ?? '-' }} <span
                                            class="text-muted">({{ $komen->tanggal_waktu_kajur ? $komen->tanggal_waktu_kajur->diffForHumans() : '-' }})</span>
                                        @if ($komen->status_kajur == 'Pending')
                                            <span class="badge badge-warning">Draft</span>
                                        @elseif($komen->status_kajur == 'Ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($komen->status_kajur == 'Disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @endif
                                    </strong>
                                    <p>{!! $komen->komentar_kajur ?? '-' !!}</p>
                                </div>
                            @endif
                            {{-- kjm --}}
                            @if ($komen->kjm)
                                <div class="list-group-item">
                                    <strong>{{ $komen->kjm->name ?? '-' }} <span
                                            class="text-muted">({{ $komen->tanggal_waktu_kjm ? $komen->tanggal_waktu_kjm->diffForHumans() : '-' }})</span>
                                        @if ($komen->status_kjm == 'Pending')
                                            <span class="badge badge-warning">Draft</span>
                                        @elseif($komen->status_kjm == 'Ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($komen->status_kjm == 'Disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @endif
                                    </strong>
                                    <p>{!! $komen->komentar_kjm ?? '-' !!}</p>
                                </div>
                            @endif
                            {{-- direktur utama --}}
                            @if ($komen->direkturUtama)
                                <div class="list-group-item">
                                    <strong>{{ $komen->direkturUtama->name ?? '-' }} <span
                                            class="text-muted">({{ $komen->tanggal_waktu_direktur_utama ? $komen->tanggal_waktu_direktur_utama->diffForHumans() : '-' }})</span>
                                        @if ($komen->status_direktur_utama == 'Pending')
                                            <span class="badge badge-warning">Draft</span>
                                        @elseif($komen->status_direktur_utama == 'Ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($komen->status_direktur_utama == 'Disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @endif
                                    </strong>
                                    <p>{!! $komen->komentar_direktur_utama ?? '-' !!}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    Revisi Draft Akreditasi
                </h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @php use Illuminate\Support\Str; @endphp
                <form action="{{ route('akreditasi.revisi', $akreditasi->id_akreditasi) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Judul PPEPP --}}
                    <div class="form-group row">
                        <label for="judul_ppepp" class="col-sm-2 col-form-label">Judul PPEPP</label>
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
                        <label>Gambar Penetapan</label>
                        <div class="row">
                            @foreach ($akreditasi->penetapan->gambarPenetapan as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_penetapan) }}"
                                            class="img-thumbnail">
                                    @elseif($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_penetapan) }}" target="_blank">Lihat
                                            PDF</a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_penetapan[]"
                                            value="{{ $gambar->id_gambar_penetapan }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Hapus</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar_penetapan">Tambah Gambar Penetapan</label>
                        <input type="file" name="gambar_penetapan[]" class="form-control" multiple>
                    </div>

                    {{-- ================= PELAKSANAAN ================= --}}
                    <div class="form-group">
                        <label for="pelaksanaan">Pelaksanaan</label>
                        <textarea name="pelaksanaan" id="pelaksanaan" class="form-control summernote" rows="4" required>{!! $akreditasi->pelaksanaan->pelaksanaan !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar Pelaksanaan</label>
                        <div class="row">
                            @foreach ($akreditasi->pelaksanaan->gambarPelaksanaan as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_pelaksanaan) }}"
                                            class="img-thumbnail">
                                    @elseif($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_pelaksanaan) }}"
                                            target="_blank">Lihat
                                            PDF</a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_pelaksanaan[]"
                                            value="{{ $gambar->id_gambar_pelaksanaan }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Hapus</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar_pelaksanaan">Tambah Gambar Pelaksanaan</label>
                        <input type="file" name="gambar_pelaksanaan[]" class="form-control" multiple>
                    </div>

                    {{-- ================= EVALUASI ================= --}}
                    <div class="form-group">
                        <label for="evaluasi">Evaluasi</label>
                        <textarea name="evaluasi" id="evaluasi" class="form-control summernote" rows="4" required>{!! $akreditasi->evaluasi->evaluasi !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar Evaluasi</label>
                        <div class="row">
                            @foreach ($akreditasi->evaluasi->gambarEvaluasi as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_evaluasi) }}"
                                            class="img-thumbnail">
                                    @elseif($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_evaluasi) }}"
                                            target="_blank">Lihat
                                            PDF</a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_evaluasi[]"
                                            value="{{ $gambar->id_gambar_evaluasi }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Hapus</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar_evaluasi">Tambah Gambar Evaluasi</label>
                        <input type="file" name="gambar_evaluasi[]" class="form-control" multiple>
                    </div>

                    {{-- ================= PENGENDALIAN ================= --}}
                    <div class="form-group">
                        <label for="pengendalian">Pengendalian</label>
                        <textarea name="pengendalian" id="pengendalian" class="form-control summernote" rows="4" required>{!! $akreditasi->pengendalian->pengendalian !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar Pengendalian</label>
                        <div class="row">
                            @foreach ($akreditasi->pengendalian->gambarPengendalian as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $gambar->gambar_pengendalian) }}"
                                            class="img-thumbnail">
                                    @elseif($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_pengendalian) }}"
                                            target="_blank">Lihat
                                            PDF</a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_pengendalian[]"
                                            value="{{ $gambar->id_gambar_pengendalian }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Hapus</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar_pengendalian">Tambah Gambar Pengendalian</label>
                        <input type="file" name="gambar_pengendalian[]" class="form-control" multiple>
                    </div>

                    {{-- ================= PENINGKATAN ================= --}}
                    <div class="form-group">
                        <label for="peningkatan">Peningkatan</label>
                        <textarea name="peningkatan" id="peningkatan" class="form-control summernote" rows="4" required>{!! $akreditasi->peningkatan->peningkatan !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar Peningkatan</label>
                        <div class="row">
                            @foreach ($akreditasi->peningkatan->gambarPeningkatan as $gambar)
                                <div class="col-md-3 mb-3">
                                    @if (Str::startsWith($gambar->mime_type, 'image/'))
                                    <img src="{{ asset('storage/' . $gambar->gambar_peningkatan) }}"
                                        class="img-thumbnail">
                                        @elseif($gambar->mime_type === 'application/pdf')
                                        <a href="{{ asset('storage/' . $gambar->gambar_peningkatan) }}"
                                            target="_blank">Lihat
                                            PDF</a>
                                    @endif
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="hapus_gambar_peningkatan[]"
                                            value="{{ $gambar->id_gambar_peningkatan }}" class="form-check-input">
                                        <label class="form-check-label text-danger">Hapus</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar_peningkatan">Tambah Gambar Peningkatan</label>
                        <input type="file" name="gambar_peningkatan[]" class="form-control" multiple>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="form-group text-right">
                        <a href="{{ route('akreditasi.index', ['slug' => $akreditasi->kriteria->route]) }}"
                            class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button id="btn-generate-pdf" type="button" class="btn btn-warning">Generate PDF</button>
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
                            title: 'Berhasil',
                            text: 'PDF berhasil dibuat.'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                'Terjadi kesalahan saat generate PDF'
                        });
                    }
                });
            });
        });
    </script>
@endpush
