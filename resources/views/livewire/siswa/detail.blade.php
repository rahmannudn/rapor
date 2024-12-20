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

    <div class="grid justify-between grid-cols-2 gap-4">
        {{-- biodata siswa --}}
        <div class="p-4 space-y-4 text-black bg-white rounded-md">
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

        {{-- rombel sekolah --}}
        <div class="w-full">
            <h2 class="mb-4 text-2xl font-bold">Rapor Siswa</h2>
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead
                    class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            NO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tahun Ajaran
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kelas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Rapor
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKelasSiswa as $kelasSiswa)
                        <tr
                            class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->index + 1 }}
                            </th>

                            <th scope="row"
                                class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $kelasSiswa['nama_kelas'] }}
                            </th>
                            <th scope="row" class="px-6 py-3">
                                {{ $kelasSiswa['tahun'] }} - {{ Str::upper($kelasSiswa['semester']) }}
                            </th>
                            <th scope="row" class="px-6 py-3">
                                <x-button class="mb-3" icon="folder-download" info label="Rapor P5"
                                    x-on:click="window.open('{{ route('cetakRaporP5', ['siswa' => $siswa, 'kelasSiswa' => $kelasSiswa['id']]) }}', '_blank')" />
                                <x-button
                                    x-on:click="window.open('{{ route('cetakRaporIntra', ['siswa' => $siswa, 'kelasSiswa' => $kelasSiswa['id']]) }}', '_blank')"
                                    icon="folder-download" info label="Rapor Intra" />
                            </th>
                        </tr>
                    @empty
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="block px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Data Tidak Ditemukan
                            </th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- rombel sekolah --}}
    </div>

    {{-- tabel riwayat kelas & proyek --}}
    <div class="w-full my-4">
        <h2 class="mb-4 text-2xl font-bold">Riwayat Kelas & Proyek</h2>
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" rowspan="2" class="px-6 py-3">NO</th>
                    <th scope="col" rowspan="2" class="px-6 py-3">Rombel</th>
                    <th scope="col" rowspan="2" class="px-6 py-3">Wali Kelas</th>
                    <th scope="col" rowspan="2" class="px-6 py-3">Tahun Ajaran</th>
                    <th scope="col" class="px-6 py-3">Judul Proyek</th>
                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                    <th scope="col" class="px-6 py-3">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatKelasProyek as $kelas)
                    @php
                        $rowCount = count($kelas['proyekData'] ?? [1]);
                    @endphp
                    @foreach ($kelas['proyekData'] ?? [] as $index => $proyek)
                        <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                            @if ($index === 0)
                                <th scope="row" rowspan="{{ $rowCount }}"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->parent->index + 1 }}
                                </th>
                                <th scope="row" rowspan="{{ $rowCount }}"
                                    class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $kelas['nama_kelas'] }}
                                </th>
                                <th scope="row" rowspan="{{ $rowCount }}" class="px-6 py-3">
                                    {{ $kelas['nama_wali_kelas'] ? $kelas['nama_wali_kelas'] : 'Belum ada Wali Kelas' }}
                                </th>
                                <th scope="row" rowspan="{{ $rowCount }}"
                                    class="px-6 py-3 border-r dark:bg-gray-800 dark:border-gray-700">
                                    {{ $kelas['tahun'] }} - {{ Str::upper($kelas['semester']) }}
                                </th>
                            @endif
                            <td class="px-6 py-3 border-r dark:bg-gray-800 dark:border-gray-700">
                                {{ $proyek['judul_proyek'] }}</td>
                            <td class="px-6 py-3 border-r dark:bg-gray-800 dark:border-gray-700">
                                {{ $proyek['deskripsi_proyek'] }}</td>
                            <td class="px-6 py-3">{{ $proyek['catatan'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" colspan="7"
                            class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            Data Tidak Ditemukan
                        </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- tabel riwayat kelas & proyek --}}

</div>
