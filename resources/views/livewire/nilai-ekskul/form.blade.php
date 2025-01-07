<div>
    @can('isWaliKelass', Auth::id())
        <p class="text-red-500 dark:bg-gray-800 dark:border-gray-700">*Kosongi kolom jika tidak mengikuti ekskul</p>
        <p class="text-gray-900 dark:bg-gray-800 dark:border-gray-700">{{ $namaKelas }}</p>
    @endcan
    <div class="md:flex md:items-center md:space-x-2 md:mb-4">
        @can('isKepsek', Auth::id())
            <div class="w-52">
                <x-native-select label="Pilih Tahun Ajaran" placeholder="Pilih Tahun Ajaran"
                    wire:model.defer="tahunAjaranAktif" x-on:change="$wire.filterDataByTahunAjaran">
                    <option value="">--Pilih Tahun Ajaran--</option>
                    @foreach ($daftarTahunAjaran as $tahun)
                        <option wire.key="{{ $tahun->id }}" value="{{ $tahun->id }}">{{ $tahun->tahun }} -
                            {{ $tahun->semester }}</option>
                    @endforeach
                </x-native-select>
            </div>

            <div class="w-52">
                <x-native-select label="Pilih Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                    x-on:change="$wire.getSiswaData">
                    <option value="">--Pilih Kelas--</option>
                    @if ($daftarKelas)
                        @foreach ($daftarKelas as $kelas)
                            <option wire.key="{{ $kelas->id }}" value="{{ $kelas->id }}">{{ $kelas->nama }} </option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
        @endcan
        <x-button class="md:mt-6"
            x-on:click="window.open('{{ route('laporan_ekskul_pdf', ['tahunAjaran' => $tahunAjaranAktif, 'kelas' => $kelasId]) }}', '_blank')"
            icon="folder-download" info label="Download Laporan Ekskul PDF" />
    </div>

    <div class="container">
        <table class="w-full responsive-table">
            <thead class="head-style">
                <tr>
                    <th class="cell-border black-text sticky-cell">NO</th>
                    <th class="cell-border black-text sticky-cell">Nama Siswa</th>
                    @can('isKepsek', Auth::id())
                        <th class="cell-border black-text ekskul-option">Kelas</th>
                    @endcan
                    <th class="cell-border black-text ekskul-option">Pilihan Ekskul 1</th>
                    <th class="cell-border black-text ekskul-description">Deskripsi Ekskul 1</th>
                    <th class="cell-border black-text ekskul-option">Pilihan Ekskul 2</th>
                    <th class="cell-border black-text ekskul-description">Deskripsi Ekskul 2</th>
                    <th class="cell-border black-text ekskul-option">Pilihan Ekskul 3</th>
                    <th class="cell-border black-text ekskul-description">Deskripsi Ekskul 3</th>
                    <th class="cell-border black-text ekskul-option">Pilihan Ekskul 4</th>
                    <th class="cell-border black-text ekskul-description">Deskripsi Ekskul 4</th>
                </tr>
            </thead>
            <tbody class="w-full">
                @if (empty($siswaData))
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cell-border">
                        <th scope="row"
                            class="block px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Data Tidak Ditemukan
                        </th>
                    </tr>
                @endif
                @foreach ($siswaData as $index => $data)
                    <tr key="{{ $data['siswa_id'] }}" class="h-20 text-center" wire:key="$data['siswa_id']">
                        <td class="px-1  w-[5%] text-center cell-border sticky-cell">
                            {{ $loop->index + 1 }}
                        </td>
                        <td scope="row" class="w-64 px-6 font-medium cell-border sticky-cell">
                            {{ $data['nama_siswa'] }}
                        </td>
                        @can('isKepsek', Auth::id())
                            <td class="px-4 ekskul-option">
                                {{ $data['nama_kelas'] }}
                            </td>
                        @endcan
                        @foreach ($data['nilai_ekskul'] as $ekskulIndex => $nilai)
                            <td class="px-4 py-6 ekskul-option cell-border" wire:key="$ekskulIndex">
                                <div class="mb-4">
                                    <select
                                        wire:model.defer="siswaData.{{ $index }}.nilai_ekskul.{{ $ekskulIndex }}.ekskul_id"
                                        @can('isKepsek', Auth::id())
                                            disabled
                                        @endcan
                                        @can('isWaliKelas', Auth::id())
                                        x-on:change="$wire.update('{{ $index }}','{{ $ekskulIndex }}','ekskul_id')"
                                        @endcan
                                        class="form-select w-full rounded-md @error('siswaData.' . $index . '.nilai_ekskul.' . $ekskulIndex . '.ekskul_id') border-red-500 @enderror">
                                        <option value="">--Pilih Eskul--</option>
                                        @foreach ($daftarEkskul as $ekskul)
                                            <option value="{{ $ekskul['id'] }}"
                                                {{ $ekskul['id'] == ($siswaData[$index]['nilai_ekskul'][$ekskulIndex]['ekskul_id'] ?? null) ? 'selected' : '' }}>
                                                {{ $ekskul['nama_ekskul'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Pesan Error -->
                                    @error('siswaData.' . $index . '.nilai_ekskul.' . $ekskulIndex . '.ekskul_id')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                            </td>
                            <td class="px-4 py-4 ekskul-description cell-border">
                                <div class="mb-4">
                                    <div class="mb-4">
                                        <textarea wire:model.defer="siswaData.{{ $index }}.nilai_ekskul.{{ $ekskulIndex }}.deskripsi"
                                            @can('isKepsek', Auth::id())
                                                disabled
                                            @endcan
                                            @can('isWaliKelas', Auth::id())
                                                x-on:blur="$wire.update('{{ $index }}','{{ $ekskulIndex }}','deskripsi')"
                                            @endcan
                                            class="w-full h-20 text-black rounded-md border @error('siswaData.' . $index . '.nilai_ekskul.' . $ekskulIndex . '.deskripsi') border-red-500 @else border-gray-300 @enderror"
                                            rows="4" placeholder="Masukkan deskripsi..."></textarea>

                                        <!-- Pesan Error -->
                                        @error('siswaData.' . $index . '.nilai_ekskul.' . $ekskulIndex . '.deskripsi')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <div class="flex mt-2 gap-x-2">
        <x-button primary label="Simpan" x-on:click="$wire.simpan" spinner />
    </div>
</div>
