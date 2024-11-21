<div>
    <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        <div class="w-52">
            <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                x-on:change="$wire.getMapel">
                <option value="">--Pilih Kelas--</option>
                @if ($selectedGuru && $daftarKelas)
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                    @endforeach
                @endif
            </x-native-select>
        </div>

        <div class="w-52">
            <x-native-select label="Mata Pelajaran" placeholder="Pilih Mapel" wire:model.defer="selectedDetailGuruMapel">
                <option value="">--Pilih Mapel--</option>
                @if ($selectedGuru && $daftarMapel)
                    @foreach ($daftarMapel as $mapel)
                        {{-- menggunakan id detail sebagai value --}}
                        <option value="{{ $mapel->detail_guru_mapel_id }}">{{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                @endif
            </x-native-select>
        </div>
    </div>
    <div class="flex justify-between my-2 gap-x-4">
        <div class="flex gap-x-2">
            <x-button primary label="Tampilkan Tabel" x-on:click="$wire.showTable" spinner />
        </div>
    </div>

    <div class="w-[60%]">
        <p><strong>Pentujuk Pengisian : </strong></p>
        {{-- <p>1. Rapor ini berasumsi bahwa guru telah melakukan penilaian formatif dan direkap dalam lembar tersendiri.</p> --}}
        <p>1. Pada Kolom KKTP, Ceklis jika siswa memenuhi KKTP.</p>
        <p>2. Pada Kolom Tampil/Tidak, ceklis jika ingin menampilkan TP di deskripsi rapor.</p>
    </div>

    @if ($showForm)
        <div class="mt-2 mb-2 space-y-4 overflow-x-auto">
            <table class="w-full text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200">
                    <tr class="">
                        <th scope="col" class="w-5 px-2 py-3" rowspan="4">
                            No
                        </th>
                        <th scope="col" class="z-20 px-6 py-3" rowspan="4">
                            Nama Siswa
                        </th>
                        @if (count($daftarTP) > 0)
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                                colspan="{{ count($daftarTP) + 2 }}">Tujuan Pembelajaran</th>
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                                rowspan="4">Deskripsi Capaian Tertinggi Dalam Rapor</th>
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                                rowspan="4">Deskripsi Capaian Terendah Dalam Rapor</th>
                    </tr>

                    <tr class="text-center">
                        @for ($i = 0; $i < count($daftarTP); $i++)
                            <th scope="col" colspan="2"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                TP {{ $i + 1 }}
                            </th>
                        @endfor
                    </tr>

                    <tr class="text-center">
                        @foreach ($daftarTP as $data)
                            <th scope="col" colspan="2" wire:key="$data['id']"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                {{ $data['deskripsi'] }}
                            </th>
                        @endforeach
                    </tr>

                    <tr class="text-center">
                        @for ($i = 0; $i < count($daftarTP); $i++)
                            <th
                                class="px-4 py-3 border-t border-b border-l border-r border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                KKTP</th>
                            <th
                                class="px-4 py-3 border-t border-b border-l border-r border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                Tampil/ Tidak</th>
                        @endfor
                    </tr>
                @else
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 border-t border-b border-l border-r border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                            Tujuan pembelajaran tidak ditemukan
                        </th>
                    </tr>
                </thead>
    @endif
    <tbody>
        @if (count($daftarTP) > 0)
            @foreach ($nilaiData as $nilaiDataIndex => $nilai)
                <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    wire:key="$nilai['siswa_id']">
                    <td class="w-5 px-4 py-4">{{ $loop->index + 1 }}</td>
                    <td class="px-4 py-4">{{ $nilai['nama_siswa'] }}</td>
                    @foreach ($nilai['detail'] as $nilaiIndex => $n)
                        <td class="flex items-center justify-center px-4 py-5 text-center border-l border-r dark:bg-gray-800 dark:border-gray-700"
                            wire:key="$nilai['siswa_id']['detail'][$nilaiIndex]">
                            <input type="checkbox" id="{{ $nilaiDataIndex }}/{{ $nilaiIndex }}"
                                wire:model.defer="nilaiData.{{ $nilaiDataIndex }}.detail.{{ $nilaiIndex }}.kktp"
                                x-on:change="$wire.update('{{ $nilaiDataIndex }}','{{ $nilaiIndex }}','kktp')"
                                @checked($nilaiData[$nilaiDataIndex]['detail'][$nilaiIndex]['kktp'])>
                        </td>
                        <td
                            class="px-4 py-4 mx-auto text-center border-l border-r dark:bg-gray-800 dark:border-gray-700">
                            <input type="checkbox" id="{{ $nilaiDataIndex }}/{{ $nilaiIndex }}"
                                wire:model.defer="nilaiData.{{ $nilaiDataIndex }}.detail.{{ $nilaiIndex }}.tampil"
                                x-on:change="$wire.update('{{ $nilaiDataIndex }}','{{ $nilaiIndex }}','tampil')"
                                @checked($nilaiData[$nilaiDataIndex]['detail'][$nilaiIndex]['tampil'])>
                        </td>
                    @endforeach
                    <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                        {{ $nilai['deskripsi_tertinggi'] }}
                    </td>
                    <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                        {{ $nilai['deskripsi_terendah'] }}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    @endif

    @push('scripts')
        <script src="{{ asset('resources/js/generateDeskripsi.js') }}"></script>
    @endpush
</div>
