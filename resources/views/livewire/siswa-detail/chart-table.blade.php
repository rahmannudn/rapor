<div class="mt-4 w-[90%]">
    @php
        // Mengolah data untuk Chart 1 (Rata-rata nilai per semester)
        $labels = [];
        $dataRataRata = [];

        foreach ($rataRataSeluruhNilai as $semester) {
            $labels[] = $semester['tingkat_kelas']; // Nama semester
            $dataRataRata[] = $semester['rata_nilai']; // Rata-rata nilai
        }

        // Mengolah data untuk Chart 2 (Nilai mata pelajaran per semester)
        $mapelLabels = [];
        $datasetsMapel = [];
        $mapelNames = [];

        foreach ($rataRataSeluruhNilai as $semester) {
            foreach ($semester['mapel'] as $mapel) {
                $mapelNames[$mapel['mapel_id']] = $mapel['nama_mapel']; // Nama mata pelajaran
            }
        }

        foreach ($mapelNames as $mapelId => $mapelName) {
            $mapelLabels[] = $mapelName;
            $dataset = [
                'label' => $mapelName,
                'data' => [],
                'backgroundColor' => 'rgba(' . rand(50, 255) . ', ' . rand(50, 255) . ', ' . rand(50, 255) . ', 0.2)',
                'borderColor' => 'rgba(' . rand(50, 255) . ', ' . rand(50, 255) . ', ' . rand(50, 255) . ', 1)',
                'borderWidth' => 1,
            ];

            foreach ($rataRataSeluruhNilai as $semester) {
                $nilaiMapel = 0;
                foreach ($semester['mapel'] as $mapel) {
                    if ($mapel['mapel_id'] == $mapelId) {
                        $nilaiMapel = $mapel['rata_nilai'];
                        break;
                    }
                }
                $dataset['data'][] = $nilaiMapel; // Tambahkan nilai per semester
            }

            $datasetsMapel[] = $dataset;
        }
    @endphp

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
            <canvas id="nilaiPersemesterChart"></canvas>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="nilai-permapel" role="tabpanel"
            aria-labelledby="nilai-permapel-tab">
            <!-- Chart 2 -->
            <div class="grid grid-cols-2 gap-4">
                @foreach ($mapelNames as $mapelId => $mapelName)
                    <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold">{{ $mapelName }}</h3>
                        <canvas id="mapelChart-{{ $mapelId }}"></canvas>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Chart 1: Rata-rata nilai per semester
                const ctx1 = document.getElementById('nilaiPersemesterChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                                label: 'Rata-rata Nilai per Semester',
                                data: @json($dataRataRata),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                type: 'line', // Tambahkan garis penghubung
                                label: `Perkembangan Nilai`,
                                data: @json($dataRataRata),
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                fill: false, // Garis tanpa isian di bawahnya
                                tension: 0.3 // Membuat garis melengkung
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Perbandingan Rata-rata Nilai Siswa per Semester'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: "Rentang Nilai",
                                    color: '#000',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: "Nilai Per Semester",
                                    color: '#000',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                }
                            }
                        }
                    }
                });

                // Chart 2
                const mapelData = @json($datasetsMapel); // Data per mapel
                const labels = @json($labels); // Semester labels

                mapelData.forEach((dataset, index) => {
                    const ctx = document.getElementById(`mapelChart-${index + 1}`).getContext('2d');
                    new Chart(ctx, {
                        type: 'bar', // Gunakan tipe "bar" sebagai tipe dasar
                        data: {
                            labels: labels,
                            datasets: [{
                                    type: 'bar',
                                    label: `Nilai ${dataset.label}`,
                                    data: dataset.data,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    type: 'line', // Tambahkan garis penghubung
                                    label: `Perkembangan ${dataset.label}`,
                                    data: dataset.data,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 2,
                                    fill: false, // Garis tanpa isian di bawahnya
                                    tension: 0.3 // Membuat garis melengkung
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: `Perkembangan Nilai ${dataset.label}`
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: "Rentang Nilai",
                                        color: '#000',
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: "Nilai Per Semester",
                                        color: '#000',
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                    }
                                }
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
</div>
