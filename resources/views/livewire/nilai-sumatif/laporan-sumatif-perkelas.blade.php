<div>
    @section('table-responsive')
        <link rel="stylesheet" href="{{ asset('resources/css/responsive-table.css') }}">
    @endsection

    @section('title')
        Laporan Nilai Sumatif
    @endsection
    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Laporan Nilai Sumatif</h1>

    @if (!empty($daftarMapel))
        <div class="relative overflow-x-auto w-[55%] mb-4 mt-2">
            <table
                class="w-full text-sm text-left text-gray-500 border border-gray-400 shadow-md rtl:text-right dark:text-gray-400 sm:rounded-lg">
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Nama Kelas
                    </th>
                    <td class="px-6 py-1">
                        {{ $dataKelas['nama_kelas'] }}
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Tahun Ajaran
                    </th>
                    <td class="px-6 py-1">
                        {{ $dataKelas['tahun'] }} / {{ $dataKelas['semester'] }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="container">
            <table class="w-full responsive-table">
                <thead class="head-style">
                    <tr>
                        <th rowspan="2" class="cell-border black-text sticky-cell">NO</th>
                        <th rowspan="2" class="cell-border black-text sticky-cell">Nama Siswa</th>
                        {{-- buatkan rowspan dan colspan --}}
                        @if (!empty($daftarMapel))
                            <th class="cell-border black-text sticky-cell" colspan="{{ count($daftarMapel) }}">
                                Nilai Akhir</th>
                        @endif
                        @if (empty($daftarMapel))
                            <th class="cell-border black-text">Mapel tidak ditemukan</th>
                        @endif
                    </tr>
                    @if (!empty($daftarMapel))
                        <tr>
                            @foreach ($daftarMapel as $mapel)
                                <th class="cell-border black-text sticky-cell">
                                    {{ $mapel['nama_mapel'] }}</th>
                            @endforeach
                        </tr>
                    @endif
                </thead>
                <tbody class="w-full">
                    @forelse($dataSiswa as $siswaIndex => $siswa)
                        <tr key="{{ $siswa['id_siswa'] }}" wire:key="$siswa['id_siswa']">
                            <td class="px-1 w-[5%] cell-border sticky-cell">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="px-4 cell-border">
                                {{ $siswa['nama_siswa'] }}
                            </td>
                            @foreach ($siswa['mapel'] as $mapel)
                                <td class="px-4 cell-border">
                                    {{ $mapel['rata_nilai'] }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cell-border">
                            <th scope="row"
                                class="block px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Data Tidak Ditemukan
                            </th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>
