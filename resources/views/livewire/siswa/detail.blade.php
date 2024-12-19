<div>
    @section('title', "Detail {$siswa['nama']}")

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Detail : {{ $siswa['nama'] }}</h1>

    {{-- biodata siswa --}}
    <div class="p-4 py-8 space-y-4 text-black bg-white rounded-md">
        <h2 class="text-2xl font-bold">Biodata</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="font-semibold">NISN</p>
                <p>{{ $siswa['nisn'] }}</p>
                <p class="font-semibold">NIDN</p>
                <p>{{ $siswa['nidn'] }}</p>
                <p class="font-semibold">Nama Siswa</p>
                <p>{{ $siswa['nama'] }}</p>
                <p class="font-semibold">Tempat Lahir</p>
                <p>{{ $siswa['tempat_lahir'] }}</p>
                <p class="font-semibold">Tanggal Lahir</p>
                <p>{{ $siswa['tanggal_lahir'] }}</p>
                <p class="font-semibold">Jenis Kelamin</p>
                <p>{{ Str::upper($siswa['jk']) }}</p>
                <p class="font-semibold">Agama</p>
                <p>{{ $siswa['agama'] }}</p>
                <p class="font-semibold">Nama Ayah</p>
                <p>{{ $siswa['nama_ayah'] }}</p>
                <p class="font-semibold">Pekerjaan Ayah</p>
                <p>{{ $siswa['pekerjaan_ayah'] }}</p>
                <p class="font-semibold">Nama Ibu</p>
                <p>{{ $siswa['nama_ibu'] }}</p>
                <p class="font-semibold">Pekerjaan Ibu</p>
                <p>{{ $siswa['pekerjaan_ibu'] }}</p>
            </div>
            <div>
                <p class="font-semibold">Alamat</p>
                <p>{{ $siswa['alamat'] }}</p>
                <p class="font-semibold">Kecamatan/Kota</p>
                <p>{{ $siswa['kecamatan'] }}, {{ $siswa['kota'] }}</p>
                <p class="font-semibold">Kelurahan</p>
                <p>{{ $siswa['kelurahan'] }}</p>
                <p class="font-semibold">Provinsi</p>
                <p>{{ $siswa['provinsi'] }}</p>
                <p class="font-semibold">Foto Siswa</p>
                @if ($siswa->foto)
                    <a href="{{ url('storage/' . $siswa['foto']) }}" target="_blank">
                        <x-avatar size="w-20" squared src="{{ url('storage/' . $siswa['foto']) }}" />
                    </a>
                @else
                    <p>BELUM ADA FOTO</p>
                @endif
            </div>
        </div>
    </div>
    {{-- biodata siswa --}}
</div>
