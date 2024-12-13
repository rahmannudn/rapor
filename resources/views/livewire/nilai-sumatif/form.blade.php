<div>
    <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        <div class="w-52">
            <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                x-on:change="$wire.getMapel">
                <option value="">--Pilih Kelas--</option>
                @if ($selectedGuruMapel && $daftarKelas)
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                    @endforeach
                @endif
            </x-native-select>
        </div>

        <div class="w-52">
            <x-native-select label="Mata Pelajaran" placeholder="Pilih Mapel"
                wire:model.change="selectedDetailGuruMapel">
                <option value="">--Pilih Mapel--</option>
                @if ($selectedGuruMapel && $daftarMapel)
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

    <div>
        <p><strong>Pentujuk Pengisian : </strong></p>
        <p>1. Asesmen Sumatif dilaksanakan tiap akhir lingkup materi dan/atau akhir semester.</p>
        <p>2. Asesmen Sumatif Akhir Semester tidak wajib untuk dilakukan, kewenangan diserahkan pada sekolah.</p>
        <p>3. Isilah dengan nilai kuantitatif sejumlah asesmen sumatif yang sudah dilakukan (tidak harus diisi semua).
        </p>
        <p>4. Bentuk asesmen sumatif tidak hanya tes tulis saja bisa beragam (proyek, unjuk kerja, observasi, dll.).</p>
    </div>

    @if ($showForm)
        <div class="flex gap-x-2">
            <x-button class="mt-6" primary icon="folder-download" label="Download Excel" spinner
                x-on:click="$wire.exportExcel" />
            <x-button class="mt-6" red icon="folder-download" label="Download PDF" spinner
                x-on:click="$wire.exportPDF" />
        </div>
        <div class="mt-2 mb-2 space-y-4 overflow-x-auto">
            <table class="w-full text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 ">
                    <tr class="">
                        <th scope="col" class="w-5 px-2 py-3" rowspan="3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3" rowspan="3">
                            Nama Siswa
                        </th>
                        @if (count($daftarLingkup) > 0)
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                                colspan="{{ count($daftarLingkup) }}">Sumatif Akhir Lingkup
                                Materi (Wajib)</th>
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                                colspan="2">Sumatif Akhir Semester (Tidak Wajib)</th>
                            {{-- <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                                rowspan="3">Total Nilai</th> --}}
                    </tr>
                    <tr>
                        @for ($i = 0; $i < count($daftarLingkup); $i++)
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                Sumatif {{ $i + 1 }}
                            </th>
                        @endfor
                        <th class="px-2 py-3"
                            class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                            rowspan="2">Non Tes</th>
                        <th class="px-2 py-3"
                            class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700"
                            rowspan="2">Tes</th>
                    </tr>
                    <tr class="">
                        @foreach ($daftarLingkup as $data)
                            <th scope="col"
                                class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                {{ $data->deskripsi }}
                            </th>
                        @endforeach
                    </tr>
                @else
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 border-t border-b border-l border-r border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                            Sumatif (Lingkup Materi) tidak ditemukan
                        </th>
                    </tr>
    @endif
    </thead>
    <tbody>
        @if (count($daftarLingkup) > 0)
            @foreach ($nilaiData as $nilaiDataIndex => $nilai)
                <tr
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-5 px-4 py-4">{{ $loop->index + 1 }}</td>
                    <td class="px-4 py-4">{{ $nilai['nama_siswa'] }}</td>
                    @foreach ($nilai['nilai'] as $nilaiIndex => $n)
                        <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                            <x-inputs.maskable mask="###"
                                wire:model="nilaiData.{{ $nilaiDataIndex }}.nilai.{{ $nilaiIndex }}.nilai_sumatif"
                                class="w-10"
                                x-on:blur="$wire.update('{{ $nilaiDataIndex }}','{{ $nilaiIndex }}')" />
                        </td>
                    @endforeach
                    <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                        <x-inputs.maskable mask="###"
                            wire:model="nilaiData.{{ $nilaiDataIndex }}.nilai_sumatif_akhir.nilai_tes" class="w-10"
                            x-on:blur="$wire.update('{{ $nilaiDataIndex }}','nilai_tes')" />
                    </td>
                    <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                        <x-inputs.maskable mask="###"
                            wire:model="nilaiData.{{ $nilaiDataIndex }}.nilai_sumatif_akhir.nilai_nontes"
                            class="w-10" x-on:blur="$wire.update('{{ $nilaiDataIndex }}','nilai_nontes')" />
                    </td>
                    {{-- <td>
                        {{ $nilaiData['total_nilai'] }}
                    </td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
</div>
<div class="flex gap-x-2">
    <x-button primary label="Simpan" x-on:click="$wire.simpan" spinner />
</div>

@endif
</div>

<script>
    document.addEventListener('livewire:init', function() {
        window.addEventListener('dataProcessed', function(data) {
            const {
                url
            } = event.detail;
            const newTab = window.open('about:blank', '_blank');
            newTab.location.href = url;
        });
    });
</script>
