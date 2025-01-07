@php
    use App\Models\Sekolah;

    $nama_sekolah = Cache::get('nama_sekolah', 'SD Negeri Kuin Utara 7');
    $logo_sekolah = Cache::get('logo_sekolah', '');
    $dataSekolah = Sekolah::where('id', 1)
        ->select('npsn', 'alamat_sekolah', 'kode_pos', 'kecamatan', 'kota', 'provinsi', 'email')
        ->first();
@endphp

<style>
    .header {
        border-bottom: 1px solid black;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .logo img {
        max-width: 100px;
        height: auto;
    }

    .header .text {
        text-align: center;
        flex-grow: 1;
        margin-left: 20px;
    }

    .header .text h1 {
        font-size: 23px;
        margin: 0;
    }

    .header .text h2 {
        font-size: 16px;
        margin: 5px 0;
    }

    .header .text p {
        font-size: 14px;
        margin: 0;
    }

    .header .text h1,
    .text h2 {
        text-transform: uppercase;
    }

    .header p {
        font-size: 12px;
        line-height: 1.5;
    }
</style>

<div>
    <div class="header">
        <div class="logo">
            <img src="{{ url('storage/' . $logo_sekolah) }} " alt="Logo {{ $nama_sekolah }}">
        </div>
        <div class="text">
            <h1>PEMERINTAH PROVINSI KALIMANTAN SELATAN <br /> DINAS PENDIDIKAN</h1>
            <h1>SEKOLAH DASAR NEGERI KUIN UTARA 7</h1>
            <p>{{ $dataSekolah['alamat'] }} e-mail: {{ $dataSekolah['email'] }}</p>
        </div>
    </div>
</div>
