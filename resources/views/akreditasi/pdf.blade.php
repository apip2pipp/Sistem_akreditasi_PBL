<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Draft Akreditasi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }
        .image {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
        }
        .gambar-wrapper {
            margin-top: 10px;
        }
        .gambar-wrapper img {
            max-height: 150px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h2>Laporan Draft Akreditasi</h2>

    <div class="section">
        <div class="section-title">1. Penetapan</div>
        {!! $akreditasi->penetapan->penetapan !!}
        @if($akreditasi->penetapan->gambarPenetapan->count())
            <div class="gambar-wrapper">
                @foreach ($akreditasi->penetapan->gambarPenetapan as $gambar)
                    <img src="file://{{ public_path('storage/' . $gambar->gambar_penetapan) }}" class="image" alt="gambar penetapan">
                @endforeach
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">2. Pelaksanaan</div>
        {!! $akreditasi->pelaksanaan->pelaksanaan !!}
        @if($akreditasi->pelaksanaan->gambarPelaksanaan->count())
            <div class="gambar-wrapper">
                @foreach ($akreditasi->pelaksanaan->gambarPelaksanaan as $gambar)
                    <img src="file://{{ public_path('storage/' . $gambar->gambar_pelaksanaan) }}" class="image" alt="gambar pelaksanaan">
                @endforeach
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">3. Evaluasi</div>
        {!! $akreditasi->evaluasi->evaluasi !!}
        @if($akreditasi->evaluasi->gambarEvaluasi->count())
            <div class="gambar-wrapper">
                @foreach ($akreditasi->evaluasi->gambarEvaluasi as $gambar)
                    <img src="file://{{ public_path('storage/' . $gambar->gambar_evaluasi) }}" class="image" alt="gambar evaluasi">
                @endforeach
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">4. Pengendalian</div>
        {!! $akreditasi->pengendalian->pengendalian !!}
        @if($akreditasi->pengendalian->gambarPengendalian->count())
            <div class="gambar-wrapper">
                @foreach ($akreditasi->pengendalian->gambarPengendalian as $gambar)
                    <img src="file://{{ public_path('storage/' . $gambar->gambar_pengendalian) }}" class="image" alt="gambar pengendalian">
                @endforeach
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">5. Peningkatan</div>
        {!! $akreditasi->peningkatan->peningkatan !!}
        @if($akreditasi->peningkatan->gambarPeningkatan->count())
            <div class="gambar-wrapper">
                @foreach ($akreditasi->peningkatan->gambarPeningkatan as $gambar)
                    <img src="file://{{ public_path('storage/' . $gambar->gambar_peningkatan) }}" class="image" alt="gambar peningkatan">
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
