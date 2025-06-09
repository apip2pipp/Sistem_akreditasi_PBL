<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Accreditation Draft</title>
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

        .section-content {
            margin-bottom: 15px;
        }

        .app-image-style {
            height: 120px;
            position: absolute;
            top: 10px;
        }
    </style>
</head>

<body>

    {{-- HEADER POLINEMA --}}
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/poltek.jpeg'))) }}"
        class="app-image-style" />

    <table align="center" border="0" cellpadding="1" class="main" style="margin-top: 10px;">
        <tbody>
            <tr>
                <td colspan="3">
                    <div align="center">
                        <span style="font-size: 18px; font-weight: bold;">
                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,<br />
                            RISET, DAN TEKNOLOGI <br />
                            POLITEKNIK NEGERI MALANG <br />
                        </span>
                        <span style="font-size: 16px;">
                            JL. Soekarno Hatta No.9 Malang 65141<br />
                            Telp (0341) 404424 - 404425 Fax (0341) 404420<br />
                            Laman://www.polinema.ac.id
                        </span>
                        <hr style="border-top: 4px double black; margin-top: 10px;" />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- JUDUL LAPORAN --}}
    <h2>Laporan Draft Akreditasi</h2>

    {{-- ISI LAPORAN --}}
    <div class="section">
        <div class="section-title">1. Penetapan</div>
        <div class="section-content">
            {!! $akreditasi->penetapan->penetapan !!}
        </div>
    </div>

    <div class="section">
        <div class="section-title">2. Pelaksanaan</div>
        <div class="section-content">
            {!! $akreditasi->pelaksanaan->pelaksanaan !!}
        </div>
    </div>

    <div class="section">
        <div class="section-title">3. Evaluasi</div>
        <div class="section-content">
            {!! $akreditasi->evaluasi->evaluasi !!}
        </div>
    </div>

    <div class="section">
        <div class="section-title">4. Pengendalian</div>
        <div class="section-content">
            {!! $akreditasi->pengendalian->pengendalian !!}
        </div>
    </div>

    <div class="section">
        <div class="section-title">5. Peningkatan</div>
        <div class="section-content">
            {!! $akreditasi->peningkatan->peningkatan !!}
        </div>
    </div>

</body>

</html>
