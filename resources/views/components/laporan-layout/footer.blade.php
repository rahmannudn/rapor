<style>
    .signatures {
        width: 100%;
        text-align: center;
        margin-top: 20px;
    }

    .signature-box {
        width: 33%;
        display: inline-block;
        vertical-align: top;
        margin: 0 45px;
        text-align: center;
    }

    .signature-line {
        margin-top: 5px;
        display: block;
        border-top: 1px solid black;
        width: 70%;
        margin-left: auto;
        margin-right: auto;
    }

    .signature-name {
        font-weight: bold;
        margin-top: 80px;
        margin-bottom: 5px;
        /* Pindahkan ke atas garis */
    }

    .signature-nip {
        margin-top: 2px;
    }
</style>

@php
    use Carbon\Carbon;

    $today = Carbon::now();

    // Array nama bulan dalam Bahasa Indonesia
    $bulanIndonesia = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    // Format tanggal secara manual
    $tanggal = $today->format('d');
    $bulan = $bulanIndonesia[(int) $today->format('m')];
    $tahun = $today->format('Y');

    $formattedDate = "$tanggal $bulan $tahun";
@endphp

<div>
    <div class="signatures">
        @if (!empty($data['wali_kelas']))
            <div class="signature-box">
                <p style="margin: 0 5px;">Banjarmasin, {{ $formattedDate }}</p>
                <p style="margin: 0 5px;">Wali Kelas</p>
                <p class="signature-name">{{ $data['wali_kelas']['nama_wali_kelas'] }}</p>
                <span class="signature-line"></span>
                <p class="signature-nip">NIP. {{ $data['wali_kelas']['nip'] }}</p>
            </div>
        @endif

        <div class="signature-box">
            <p style="margin: 0 5px;">Mengetahui,</p>
            <p style="margin: 0 5px;">Kepala Sekolah</p>
            <p class="signature-name">{{ $data['kepsek']['nama_kepsek'] }}</p>
            <span class="signature-line"></span>
            <p class="signature-nip">NIP.{{ $data['kepsek']['nip'] }}</p>
        </div>
    </div>
</div>
