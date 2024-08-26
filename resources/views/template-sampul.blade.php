<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Peserta Didik</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .page {
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        #halaman-3 {
            height: auto;
            min-height: 297mm;
        }

        .content {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            width: 250px;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            font-size: 35px;
            margin-bottom: 20px;
            text-align: center;
        }

        .student-info {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .student-name,
        .student-id {
            border: 1px solid #000;
            padding: 5px;
            margin-top: 5px;
            font-weight: bold;
            font-size: 30px;
        }

        .text-label {
            font-size: 22px;
        }

        .school-info {
            width: 100%;
            text-align: left;
            margin-top: 40px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            width: 200px;
            font-weight: bold;
        }

        .info-value {
            flex: 1;
        }

        .page-title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .school-info {
            margin-top: 80px;
        }

        .school-info span {
            font-size: 22px;
        }

        .identity-info {
            width: 100%;
            text-align: left;
            margin-top: 20px;
        }

        .identity-info .info-row {
            margin-bottom: 6px;
        }

        .sub-label {
            padding-left: 20px;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
            page-break-after: avoid;
        }

        .signature-content {
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
            margin-right: 80px;
        }

        .signature-box {
            width: 120px;
            height: 180px;
            border: 1px solid #000;
            margin-right: 50px;
        }

        .signature-text {
            text-align: left;
        }

        .signature-text p {
            margin: 0;
            line-height: 1.5;
        }

        .signature-text p:nth-child(4) {
            font-weight: bold;
        }

        @media print {
            #printButton {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Halaman 1 -->
    <div class="page">
        <button id="printButton" style="background: red; padding:20px; text-color:white;">Print</button>
        <div class="content">
            @if ($results['sekolah']['logo_sekolah'])
                <img src="{{ url('storage/' . $results['sekolah']['logo_sekolah']) }}" alt="Sekolah Logo" class="logo">
            @endif
            <h1 style="margin:120px 0;">RAPOR<br>PESERTA DIDIK<br>SEKOLAH DASAR<br>(SD)</h1>
            <div class="student-info">
                <p class="text-label">Nama Peserta Didik:</p>
                <div class="student-name">{{ $results['siswa']['nama'] }}</div>
                <p style="margin-top: 20px;" class="text-label">NIS / NISN :</p>
                <div class="student-id">{{ $results['siswa']['nidn'] }} / {{ $results['siswa']['nisn'] }}</div>
            </div>
        </div>
    </div>

    <!-- Halaman 2 -->
    <div class="page">
        <div class="content">
            <div class="page-title">
                RAPOR<br>PESERTA DIDIK<br>SEKOLAH DASAR ( SD )
            </div>
            <div class="school-info">
                <div class="info-row">
                    <span class="info-label">Nama Sekolah</span>
                    <span class="info-value">: {{ $results['sekolah']['nama_sekolah'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">NPSN</span>
                    <span class="info-value">: {{ $results['sekolah']['npsn'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat Sekolah</span>
                    <span class="info-value">: {{ $results['sekolah']['alamat_sekolah'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kode Pos</span>
                    <span class="info-value">: {{ $results['sekolah']['kode_pos'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Desa / Kelurahan</span>
                    <span class="info-value">: {{ $results['sekolah']['kelurahan'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kecamatan</span>
                    <span class="info-value">: {{ $results['sekolah']['kecamatan'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kabupaten / Kota</span>
                    <span class="info-value">: {{ $results['sekolah']['kota'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Provinsi</span>
                    <span class="info-value">: {{ $results['sekolah']['provinsi'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Website</span>
                    <span class="info-value">:</span>
                </div>
                <div class="info-row">
                    <span class="info-label">E-mail</span>
                    <span class="info-value">: {{ $results['sekolah']['email'] }} </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Halaman 3 -->
    <div class="page" id="halaman-3">
        <div class="content">
            <h2 class="page-title">IDENTITAS PESERTA DIDIK</h2>
            <div class="identity-info">
                <div class="info-row">
                    <span class="info-label">Nama Peserta Didik</span>
                    <span class="info-value">: {{ $results['siswa']['nama'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">NIS / NISN</span>
                    <span class="info-value">: {{ $results['siswa']['nidn'] }} /
                        {{ $results['siswa']['nisn'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tempat, Tanggal Lahir</span>
                    <span class="info-value">: {{ $results['siswa']['tempat_lahir'] }},
                        {{ \Carbon\Carbon::parse($results['siswa']['tgl_lahir'])->translatedFormat('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value">: @if ($results['siswa']['jk'] === 'p')
                            Perempuan
                        @else
                            Laki - Laki
                        @endif </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Agama</span>
                    <span class="info-value">: {{ $results['siswa']['agama'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pendidikan sebelumnya</span>
                    <span class="info-value">: </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat Peserta Didik</span>
                    <span class="info-value">: {{ $results['siswa']['alamat'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Orang Tua</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Ayah</span>
                    <span class="info-value">: {{ $results['siswa']['nama_ayah'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Ibu</span>
                    <span class="info-value">: {{ $results['siswa']['nama_ibu'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pekerjaan Orang Tua</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Ayah</span>
                    <span class="info-value">: {{ $results['siswa']['pekerjaan_ayah'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Ibu</span>
                    <span class="info-value">: {{ $results['siswa']['pekerjaan_ibu'] }}</span>
                </div>
                {{-- <div class="info-row">
                    <span class="info-label">Alamat Orang Tua</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Jalan</span>
                    <span class="info-value">: Kuin Utara</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Kelurahan/Desa</span>
                    <span class="info-value">: Kuin Utara</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Kecamatan</span>
                    <span class="info-value">: Banjarmasin Utara</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Kabupaten/Kota</span>
                    <span class="info-value">: Banjarmasin</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Provinsi</span>
                    <span class="info-value">: Kalimantan Selatan</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Wali Peserta Didik</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Nama</span>
                    <span class="info-value">:</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Pekerjaan</span>
                    <span class="info-value">:</span>
                </div>
                <div class="info-row">
                    <span class="info-label sub-label">Alamat</span>
                    <span class="info-value">:</span>
                </div> --}}
            </div>
            <div class="signature">
                <div class="signature-content">
                    <!-- <div class="signature-box"></div> -->
                    @if ($results['siswa']['foto'])
                        <img src="{{ url($results['siswa']['foto']) }}" class="signature-box" alt="">
                    @endif
                    <div class="signature-text">
                        <p>Banjarmasin, {{ $results['kepsek']['tgl_rapor'] }}</p>
                        <p>Kepala Sekolah,</p>
                        <br><br><br><br><br>
                        <p><u>{{ $results['kepsek']['nama_kepsek'] }}</u></p>
                        <p>NIP. {{ $results['kepsek']['nip_kepsek'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById("printButton").onclick = function() {
        window.print();
    }
    window.onload = function() {
        // Tampilkan window print setelah halaman selesai dimuat
        window.print();
    };
</script>

</html>
