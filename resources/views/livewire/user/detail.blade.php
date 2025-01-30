<div>

    <x-slot:title>
        {{ $user['name'] }}
    </x-slot:title>

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Detail : {{ $user['name'] }}</h1>

    <x-button href="{{ route('user.index') }}" class="mb-3" icon="arrow-left" info label="Kembali" />

    <div class="grid justify-between grid-cols-2 gap-4">
        {{-- biodata pengguna --}}
        <div class="p-4 space-y-4 text-black bg-white rounded-md">
            <h2 class="text-2xl font-bold">Biodata</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <p class="font-semibold">NIP</p>
                    <p>{{ $user['nip'] ?? '-' }}</p>
                    <p class="font-semibold">Nama Siswa</p>
                    <p>{{ $user['name'] }}</p>
                    <p class="font-semibold">Email</p>
                    <p>{{ $user['email'] }}</p>
                    <p class="font-semibold">Jenis Kelamin</p>
                    <p>{{ Str::upper($user['jk']) }}</p>
                    <p class="font-semibold">Jenis Pengguna</p>
                    <p>{{ Str::upper($user['role']) }}</p>
                    <p class="font-semibold">Jenis Pegawai</p>
                    <p>{{ Str::upper($user['jenis_pegawai']) }}</p>
                </div>
            </div>
        </div>
        {{-- biodata pengguna --}}

        @if ($user->role === 'guru')
            <div class="w-full space-y-4">
                {{-- riwayat mapel --}}
                <div>
                    <h2 class="mb-4 text-2xl font-bold">Riwayat Mengajar Mapel</h2>
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead
                            class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NO
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tahun Ajaran
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Mapel
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatMapel as $mapel)
                                @php
                                    $rowCount = count($mapel['dataMapel'] ?? [1]);
                                @endphp
                                @foreach ($mapel['dataMapel'] ?? [] as $index => $riwayatMapel)
                                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                                        @if ($index === 0)
                                            <th scope="row" rowspan="{{ $rowCount }}"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $loop->parent->index + 1 }}
                                            </th>
                                            <th scope="row" rowspan="{{ $rowCount }}"
                                                class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $mapel['nama_kelas'] }}
                                            </th>
                                            <th scope="row" rowspan="{{ $rowCount }}"
                                                class="px-6 py-3 border-r dark:bg-gray-800 dark:border-gray-700">
                                                {{ $mapel['tahun'] }} - {{ Str::upper($mapel['semester']) }}
                                            </th>
                                        @endif
                                        <td class="px-6 py-3 border-r dark:bg-gray-800 dark:border-gray-700">
                                            {{ $riwayatMapel['nama_mapel'] }}</td>
                                    </tr>
                                @endforeach
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
                {{-- riwayat mapel --}}
            </div>
        @endif
    </div>

    {{-- tabel riwayat kelas & proyek --}}
    @if ($user->role === 'guru')
        <div class="w-full my-4">
            <h2 class="mb-4 text-2xl font-bold">Riwayat Kelas & Proyek</h2>
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead
                    class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" rowspan="2" class="px-6 py-3">NO</th>
                        <th scope="col" rowspan="2" class="px-6 py-3">Rombel</th>
                        <th scope="col" rowspan="2" class="px-6 py-3">Wali Kelas</th>
                        <th scope="col" rowspan="2" class="px-6 py-3">Tahun Ajaran</th>
                        <th scope="col" class="px-6 py-3">Judul Proyek</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
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
    @endif
    {{-- tabel riwayat kelas & proyek --}}
</div>
