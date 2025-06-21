<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Accreditation Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-3 font-weight-bold">Title of PPEPP</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext">{{ $akreditasi->judul_ppepp }}</p>
                </div>
            </div>

            <!-- Display PDF -->
            <div class="mb-4">
                <embed src="{{ url('storage/' . $fileAkreditasi->file_akreditasi) }}" type="application/pdf"
                    width="100%" height="600px">
            </div>

            @php use Illuminate\Support\Str; @endphp
            {{-- gambar penetapan --}}
            <div class="form-group">
                <label>Supporting Documents Penetapan</label>
                <div class="row">
                    @foreach ($akreditasi->penetapan->gambarPenetapan as $gambar)
                        <div class="col-md-3 mb-3">
                            @if (Str::startsWith($gambar->mime_type, 'image/'))
                                <img src="{{ asset('storage/' . $gambar->gambar_penetapan) }}" class="img-thumbnail">
                            @elseif($gambar->mime_type === 'application/pdf')
                                <a href="{{ asset('storage/' . $gambar->gambar_penetapan) }}" target="_blank">See
                                    PDF</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- gambar PELAKSANAAN --}}
            <div class="form-group">
                <label>Supporting Documents Pelaksanaan</label>
                <div class="row">
                    @foreach ($akreditasi->pelaksanaan->gambarPelaksanaan as $gambar)
                        <div class="col-md-3 mb-3">
                            @if (Str::startsWith($gambar->mime_type, 'image/'))
                                <img src="{{ asset('storage/' . $gambar->gambar_pelaksanaan) }}" class="img-thumbnail">
                            @elseif($gambar->mime_type === 'application/pdf')
                                <a href="{{ asset('storage/' . $gambar->gambar_pelaksanaan) }}" target="_blank">See
                                    PDF</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- gambar EVALUASI --}}
            <div class="form-group">
                <label>Supporting Documents Evaluasi</label>
                <div class="row">
                    @foreach ($akreditasi->evaluasi->gambarEvaluasi as $gambar)
                        <div class="col-md-3 mb-3">
                            @if (Str::startsWith($gambar->mime_type, 'image/'))
                                <img src="{{ asset('storage/' . $gambar->gambar_evaluasi) }}" class="img-thumbnail">
                            @elseif($gambar->mime_type === 'application/pdf')
                                <a href="{{ asset('storage/' . $gambar->gambar_evaluasi) }}" target="_blank">See
                                    PDF</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- gambar PENGENDALIAN --}}
            <div class="form-group">
                <label>Supporting Documents Pengendalian</label>
                <div class="row">
                    @foreach ($akreditasi->pengendalian->gambarPengendalian as $gambar)
                        <div class="col-md-3 mb-3">
                            @if (Str::startsWith($gambar->mime_type, 'image/'))
                                <img src="{{ asset('storage/' . $gambar->gambar_pengendalian) }}" class="img-thumbnail">
                            @elseif($gambar->mime_type === 'application/pdf')
                                <a href="{{ asset('storage/' . $gambar->gambar_pengendalian) }}" target="_blank">See
                                    PDF</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- gambar PENINGKATAN --}}
            <div class="form-group">
                <label>Supporting Documents Peningkatan</label>
                <div class="row">
                    @foreach ($akreditasi->peningkatan->gambarPeningkatan as $gambar)
                        <div class="col-md-3 mb-3">
                            @if (Str::startsWith($gambar->mime_type, 'image/'))
                                <img src="{{ asset('storage/' . $gambar->gambar_peningkatan) }}" class="img-thumbnail">
                            @elseif($gambar->mime_type === 'application/pdf')
                                <a href="{{ asset('storage/' . $gambar->gambar_peningkatan) }}" target="_blank">See
                                    PDF</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if (auth()->user()->level->level_nama === 'Kaprodi' || auth()->user()->level->level_kode === 'KPD')
                @if ($fileAkreditasi->status_kaprodi === 'Pending')
                    <!-- Form to Update Status and Comment -->
                    <form action="{{ route('akreditasi.status.kaprodi', $akreditasi->id_akreditasi) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="status_kaprodi">Status Kaprodi:</label>
                            <select name="status_kaprodi" id="status_kaprodi" class="form-control" required>
                                <option value="Disetujui"
                                    {{ old('status_kaprodi', $fileAkreditasi->status_kaprodi) == 'Disetujui' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="Ditolak"
                                    {{ old('status_kaprodi', $fileAkreditasi->status_kaprodi) == 'Ditolak' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                            @error('status_kaprodi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="komentar_kaprodi">Comments from Kaprodi:</label>
                            <textarea name="komentar_kaprodi" id="komentar_kaprodi" class="form-control" rows="4" required>{{ old('komentar_kaprodi', $fileAkreditasi->komentar_kaprodi) }}</textarea>
                            @error('komentar_kaprodi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Status Kaprodi</button>
                    </form>
                @endif
            @endif

            @if (auth()->user()->level->level_nama === 'Kajur' || auth()->user()->level->level_kode === 'KJR')
                @if (
                    $fileAkreditasi->status_kajur === 'Pending' &&
                        $fileAkreditasi->status_kaprodi === 'Disetujui' &&
                        $akreditasi->status != 'revisi')
                    <!-- Form to Update Status and Comment -->
                    <form action="{{ route('akreditasi.status.kajur', $akreditasi->id_akreditasi) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="status_kajur">Status Kajur:</label>
                            <select name="status_kajur" id="status_kajur" class="form-control" required>
                                <option value="Disetujui"
                                    {{ old('status_kajur', $fileAkreditasi->status_kajur) == 'Disetujui' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="Ditolak"
                                    {{ old('status_kajur', $fileAkreditasi->status_kajur) == 'Ditolak' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                            @error('status_kajur')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="komentar_kajur">Comments from Kajur:</label>
                            <textarea name="komentar_kajur" id="komentar_kajur" class="form-control" rows="4" required>{{ old('komentar_kajur', $fileAkreditasi->komentar_kajur) }}</textarea>
                            @error('komentar_kajur')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Status Kajur</button>
                    </form>
                @endif
            @endif

            @if (auth()->user()->level->level_nama === 'KJM' || auth()->user()->level->level_kode ===  'KJM')
                @if (
                    $fileAkreditasi->status_kjm === 'Pending' &&
                        $fileAkreditasi->status_kaprodi === 'Disetujui' &&
                        $fileAkreditasi->status_kajur === 'Disetujui' &&
                        $akreditasi->status != 'revisi')
                    <!-- Form to Update Status and Comment -->
                    <form action="{{ route('akreditasi.status.kjm', $akreditasi->id_akreditasi) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="status_kjm">Status KJM:</label>
                            <select name="status_kjm" id="status_kjm" class="form-control" required>
                                <option value="Disetujui"
                                    {{ old('status_kjm', $fileAkreditasi->status_kjm) == 'Disetujui' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="Ditolak"
                                    {{ old('status_kjm', $fileAkreditasi->status_kjm) == 'Ditolak' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                            @error('status_kjm')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="komentar_kjm">Comments from KJM:</label>
                            <textarea name="komentar_kjm" id="komentar_kjm" class="form-control" rows="4" required>{{ old('komentar_kjm', $fileAkreditasi->komentar_kjm) }}</textarea>
                            @error('komentar_kjm')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Status KJM</button>
                    </form>
                @endif
            @endif

            @if (auth()->user()->level->level_nama === 'Direktur' || auth()->user()->level->level_kode === 'DIR')
                @if (
                    $fileAkreditasi->status_direktur_utama === 'Pending' &&
                        $fileAkreditasi->status_kaprodi === 'Disetujui' &&
                        $fileAkreditasi->status_kajur === 'Disetujui' &&
                        $fileAkreditasi->status_kjm === 'Disetujui' &&
                        $akreditasi->status != 'revisi')
                    <!-- Form to Update Status and Comment -->
                    <form action="{{ route('akreditasi.status.direktur_utama', $akreditasi->id_akreditasi) }}"
                        method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="status_direktur_utama">Status Direktur Utama:</label>
                            <select name="status_direktur_utama" id="status_direktur_utama" class="form-control"
                                required>
                                <option value="Disetujui"
                                    {{ old('status_direktur_utama', $fileAkreditasi->status_direktur_utama) == 'Disetujui' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="Ditolak"
                                    {{ old('status_direktur_utama', $fileAkreditasi->status_direktur_utama) == 'Ditolak' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                            @error('status_direktur_utama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="komentar_direktur_utama">Comments from Direktur Utama:</label>
                            <textarea name="komentar_direktur_utama" id="komentar_direktur_utama" class="form-control" rows="4" required>{{ old('komentar_direktur_utama', $fileAkreditasi->komentar_direktur_utama) }}</textarea>
                            @error('komentar_direktur_utama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Status Direktur Utama</button>
                    </form>
                @endif
            @endif

            <div class="mt-4">
                <h5>Status and Comments</h5>
                @foreach ($fileAkreditasiShow as $file)
                    {{-- Kaprodi --}}
                    @if ($file->status_kaprodi)
                        <div class="media p-3 rounded shadow-sm bg-light mb-3">
                            <!-- Avatar and User Info -->
                            <img src="#" class="mr-3 rounded-circle" width="40" alt="Kaprodi">
                            <div class="media-body">
                                <h6 class="mt-0"><strong>{{ $file->kaprodi->name ?? '-' }} -
                                        {{ $file->kaprodi->level->level_nama ?? '-' }}</strong>
                                </h6>
                                <small class="text-muted">
                                    {{ $file->tanggal_waktu_kaprodi ? $file->tanggal_waktu_kaprodi->diffForHumans() : '-' }}
                                </small>
                                <!-- Comment Content -->
                                <p class="mt-2">
                                    <strong>Status:</strong> {{ $file->status_kaprodi ?? '-' }}
                                </p>
                                <h6><strong>Comments:</strong></h6>
                                <p>{!! $file->komentar_kaprodi ?? '-' !!}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Kajur --}}
                    @if ($file->kajur)
                        <div class="media p-3 rounded shadow-sm bg-light mb-3">
                            <!-- Avatar and User Info -->
                            <img src="#" class="mr-3 rounded-circle" width="40" alt="kajur">
                            <div class="media-body">
                                <h6 class="mt-0"><strong>{{ $file->kajur->name ?? '-' }} -
                                        {{ $file->kajur->level->level_nama ?? '-' }}</strong>
                                </h6>
                                <small class="text-muted">
                                    {{ $file->tanggal_waktu_kajur ? $file->tanggal_waktu_kajur->diffForHumans() : '-' }}
                                </small>
                                <!-- Comment Content -->
                                <p class="mt-2">
                                    <strong>Status:</strong> {{ $file->status_kajur ?? '-' }}
                                </p>
                                <h6><strong>Comments:</strong></h6>
                                <p>{!! $file->komentar_kajur ?? '-' !!}</p>
                            </div>
                        </div>
                    @endif

                    {{-- KJM --}}
                    @if ($file->kjm)
                        <div class="media p-3 rounded shadow-sm bg-light mb-3">
                            <!-- Avatar and User Info -->
                            <img src="#" class="mr-3 rounded-circle" width="40" alt="kjm">
                            <div class="media-body">
                                <h6 class="mt-0"><strong>{{ $file->kjm->name ?? '-' }} -
                                        {{ $file->kjm->level->level_nama ?? '-' }}</strong>
                                </h6>
                                <small class="text-muted">
                                    {{ $file->tanggal_waktu_kjm ? $file->tanggal_waktu_kjm->diffForHumans() : '-' }}
                                </small>
                                <!-- Comment Content -->
                                <p class="mt-2">
                                    <strong>Status:</strong> {{ $file->status_kjm ?? '-' }}
                                </p>
                                <h6><strong>Comments:</strong></h6>
                                <p>{!! $file->komentar_kjm ?? '-' !!}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Direktur Utama --}}
                    @if ($file->direkturUtama)
                        <div class="media p-3 rounded shadow-sm bg-light mb-3">
                            <!-- Avatar and User Info -->
                            <img src="#" class="mr-3 rounded-circle" width="40" alt="kjm">
                            <div class="media-body">
                                <h6 class="mt-0"><strong>{{ $file->direkturUtama->name ?? '-' }} -
                                        {{ $file->direkturUtama->level->level_nama ?? '-' }}</strong>
                                </h6>
                                <small class="text-muted">
                                    {{ $file->tanggal_waktu_direktur_utama ? $file->tanggal_waktu_direktur_utama->diffForHumans() : '-' }}
                                </small>
                                <!-- Comment Content -->
                                <p class="mt-2">
                                    <strong>Status:</strong> {{ $file->status_direktur_utama ?? '-' }}
                                </p>
                                <h6><strong>Comments:</strong></h6>
                                <p>{!! $file->komentar_direktur_utama ?? '-' !!}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>



        </div>

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>

<!-- Include Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">

<script>
    $(document).ready(function() {
        $('#komentar_kaprodi', '#komentar_kajur', '#komentar_kjm', '#komentar_direktur_utama').summernote({
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
