<div class="mt-4">
    <h2 class="mb-4 text-2xl font-bold">Grafik Perkembangan Nilai Siswa</h2>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="nilai-keseluruhan-tab"
                    data-tabs-target="#nilai-keseluruhan" type="button" role="tab"
                    aria-controls="nilai-keseluruhan" aria-selected="false">Nilai Keseluruhan</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="nilai-permapel-tab" data-tabs-target="#nilai-permapel" type="button" role="tab"
                    aria-controls="nilai-permapel" aria-selected="false">Nilai Permapel</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="nilai-keseluruhan" role="tabpanel"
            aria-labelledby="nilai-keseluruhan-tab">
            {{-- {!! $nilaiSiswaPersemester->container() !!} --}}
            <canvas id="nilaiPersemesterChart"></canvas>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="nilai-permapel" role="tabpanel"
            aria-labelledby="nilai-permapel-tab">
            {{-- {!! $nilaiSiswaPerMapel->container() !!} --}}
            {{-- <div class="grid grid-cols-2 gap-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                        class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>.
                    Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                    classes to control the content visibility and styling.</p>
            </div> --}}
        </div>
    </div>

    @php
        // Mengolah data dari $rataRataSeluruhNilai
        $labels = [];
        $dataRataRata = [];

        foreach ($rataRataSeluruhNilai as $semester) {
            $labels[] = $semester['tingkat_kelas']; // Nama semester
            $dataRataRata[] = $semester['rata_nilai']; // Rata-rata nilai
        }
    @endphp

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('nilaiPersemesterChart').getContext('2d');
                const data = {
                    labels: @json($labels), // Label semester
                    datasets: [{
                        label: 'Rata-rata Nilai per Semester',
                        data: @json($dataRataRata), // Data rata-rata nilai
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'bar', // Gunakan tipe chart bar
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Perbandingan Rata-rata Nilai Siswa per Semester'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endsection
</div>
