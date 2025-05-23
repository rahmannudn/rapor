@php
    function warnaKehadiran(float $persen): string
    {
        return match (true) {
            $persen < 60 => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            $persen < 80 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            default => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        };
    }
@endphp


<div>
    <x-slot:title>
        Laporan Absensi
    </x-slot:title>
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Laporan Absensi</h1>

    <div class="flex flex-col w-full mb-2 space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        <div>
            <x-native-select class="max-w-72" label="Tahun Ajaran" placeholder="Pilih Tahun Ajaran"
                wire:model.defer="selectedTahunAjaran" x-on:change="$wire.getDaftar" autofocus>
                @foreach ($daftarTahunAjaran as $ta)
                    <option value="{{ $ta->id }}"> {{ $ta->tahun }}-{{ $ta->semester }} </option>
                @endforeach
            </x-native-select>
        </div>
        <div>
            <x-native-select class="max-w-72" label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                x-on:change="$wire.getSiswaData" autofocus>
                <option value=""> Semua </option>
                @foreach ($daftarKelas as $kelas)
                    <option value="{{ $kelas->id }}"> {{ $kelas->nama }} </option>
                @endforeach
            </x-native-select>
        </div>
        <div>
            <x-native-select class="max-w-72" label="Bulan" placeholder="Pilih Bulan" wire:model.defer="selectedBulan"
                x-on:change="$wire.getSiswaData" autofocus>
                <option value=""> Semua </option>
                @foreach ($daftarBulan as $key => $bulan)
                    <option value="{{ $key }}"> {{ $bulan }}</option>
                @endforeach
            </x-native-select>
        </div>
        <div class="block md:w-20">
            <x-native-select label="Show" wire:model.change='show'>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </x-native-select>
        </div>
    </div>

    <div class="flex flex-col w-full mb-2 space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        <x-button primary icon="folder-download" label="Download Excel" spinner x-on:click="$wire.exportExcel" />
    </div>

    <div class="flex flex-col gap-6 lg:flex-row">
        <div class="max-w-[750px] w-full p-2 bg-white rounded-lg">
            <h2 class="mb-1 text-xl font-semibold text-slate-700">Absensi Perkelas</h2>
            <livewire:absensi.table-perkelas :absensiKelas="$absensiKelas" />
        </div>
        <div class="w-full p-2 bg-white rounded-lg">
            <h2 class="mb-1 text-xl font-semibold text-slate-700">Prensentase Absensi</h2>
            <canvas id="absensiKelasChart" class="mx-auto max-w-[500px] max-h-[500px]"></canvas>
        </div>
    </div>
    <h2 class="mb-1 text-xl font-semibold text-slate-700">Absensi Siswa</h2>
    @if ($siswaData)
        {{-- table --}}
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        NO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kelas
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Jumlah Kehadiran
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Jumlah Sakit
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Jumlah Izin
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Jumlah Alfa
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Presentase Kehadiran
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswaData as $data)
                    <tr wire:key="{{ $data['siswa_id'] }}"
                        class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $siswaData->firstItem() + $loop->index }}
                        </th>

                        <th scope="row"
                            class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $data['nama_siswa'] }}
                        </th>
                        <th scope="row" class="px-6 py-3">
                            {{ $data['nama_kelas'] }}
                        </th>
                        <td class="px-4 py-4">
                            {{ $data['total_hari_efektif'] }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $data['total_sakit'] }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $data['total_izin'] }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $data['total_alfa'] }}
                        </td>
                        <td class="px-4 py-4">
                            <span
                                class="{{ warnaKehadiran($data['presentase_kehadiran']) }} text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm">{{ $data['presentase_kehadiran'] }}
                                %</span>
                        </td>
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


        <div class="px-4 py-2 bg-slate-300">
            {{ $paginatedSiswa->links() }}
        </div>
    @endif
    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let data = @json($rekapKehadiran);
                const ctx = document.getElementById('absensiKelasChart').getContext('2d');

                donutChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Hadir', 'Alfa', 'Sakit', 'Izin'],
                        datasets: [{
                            label: 'Absensi',
                            data: [
                                data.jumlah_kehadiran,
                                data.jumlah_alfa,
                                data.jumlah_sakit,
                                data.jumlah_izin
                            ],
                            backgroundColor: ['#4ade80', '#f87171', '#facc15', '#60a5fa'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            });
        </script>
    @endsection
</div>
