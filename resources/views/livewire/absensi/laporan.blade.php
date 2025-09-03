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


<div x-on:rekap-kehadiran-updated="renderChart($event.detail)">
    <x-slot:title>
        Laporan Absensi
    </x-slot:title>
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Laporan Absensi</h1>

    <div class="block mb-4 space-y-2 md:flex md:items-center md:justify-between md:space-y-0 md:space-x-2">
        <div class="flex flex-row items-center space-x-2 md:w-[70%]">
            <div class="max-w-72">
                <x-native-select label="Tahun Ajaran" placeholder="Pilih TA" wire:model="selectedTahunAjaran"
                    x-on:change="$wire.getSiswaData" autofocus>
                    @if (isset($daftarTahunAjaran))
                        @foreach ($daftarTahunAjaran as $tahun)
                            <option wire:key="{{ $tahun['id'] }}" value="{{ $tahun['id'] }}"> {{ $tahun['tahun'] }} -
                                {{ $tahun['semester'] }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="max-w-30">
                <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model="selectedKelas"
                    x-on:change="$wire.getSiswaData" autofocus>
                    <option value=""> Semua </option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}"> {{ $kelas->nama }} </option>
                    @endforeach
                </x-native-select>
            </div>

            <div class="max-w-72">
                <x-native-select label="Bulan" placeholder="Pilih Bulan" wire:model="selectedBulan"
                    x-on:change="$wire.getSiswaData" autofocus>
                    <option value=""> Semua </option>
                    @if (isset($daftarBulan))
                        @foreach ($daftarBulan as $key => $bulan)
                            <option value="{{ $key }}"> {{ $bulan }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="max-w-20">
                <x-native-select label="Show" wire:model.change='show'>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-native-select>
            </div>

            <x-button primary icon="folder-download" label="Download Excel" class="mt-6" spinner
                x-on:click="$wire.exportExcel" />
            <x-button class="mt-6" red icon="folder-download" label="Download PDF" spinner
                x-on:click="window.open('{{ route('laporanAbsensiPDF', ['tahunAjaran' => $selectedTahunAjaran, 'kelas' => $selectedKelas]) }}', '_blank')" />
        </div>
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
                            <a href="{{ route('detail_siswa', $data['siswa_id']) }}" class="text-blue-800 underline"
                                target="_blank">{{ $data['nama_siswa'] }}</a>
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
            let donutChart;

            function renderChart(rekapData = null) {
                console.log(rekapData)
                let data = rekapData ? rekapData[0] : @json($rekapKehadiran);
                const ctx = document.getElementById('absensiKelasChart').getContext('2d');

                if (donutChart) {
                    donutChart.destroy();
                }

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
            }

            document.addEventListener('DOMContentLoaded', function() {
                renderChart();
            });
        </script>
    @endsection
</div>
