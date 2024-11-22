<div>
    <p class="text-red-500 dark:bg-gray-800 dark:border-gray-700">*Kosongi kolom jika tidak mengikuti ekskul</p>
    <p class="text-gray-900 dark:bg-gray-800 dark:border-gray-700">{{ $namaKelas }}</p>
    <div class="container">
        <table class="w-full responsive-table">
            <thead class="head-style">
                <tr>
                    <th class="cell-border black-text sticky-cell">NO</th>
                    <th class="cell-border black-text sticky-cell">Nama Siswa</th>
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
                @forelse($siswaData as $index => $data)
                    <tr key="{{ $data['siswa_id'] }}" class="h-20 text-center" wire:key="$data['siswa_id']">
                        <td class="px-1  w-[5%] text-center cell-border sticky-cell">
                            {{ $loop->index + 1 }}
                        </td>
                        <td scope="row" class="w-64 px-6 font-medium cell-border sticky-cell">
                            {{ $data['nama_siswa'] }}
                        </td>
                        @foreach ($data['nilai_ekskul'] as $ekskulIndex => $nilai)
                            <td class="px-4 py-6 ekskul-option cell-border" wire:key="$ekskulIndex">
                                <x-native-select class="h-20"
                                    wire:model.defer="siswaData.{{ $index }}.nilai_ekskul.{{ $ekskulIndex }}.ekskul_id"
                                    x-on:change="$wire.update('{{ $index }}','{{ $ekskulIndex }}','ekskul_id')">
                                    <option value="">--Pilih Eskul--</option>
                                    @foreach ($daftarEkskul as $ekskul)
                                        <option value="{{ $ekskul['id'] }}" class="w-full">
                                            {{ $ekskul['nama_ekskul'] }}
                                        </option>
                                    @endforeach
                                </x-native-select>
                            </td>
                            <td class="px-4 py-4 ekskul-description cell-border">
                                <x-textarea
                                    wire:model.defer="siswaData.{{ $index }}.nilai_ekskul.{{ $ekskulIndex }}.deskripsi"
                                    x-on:blur="$wire.update('{{ $index }}','{{ $ekskulIndex }}','deskripsi')"
                                    class="text-black" />
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
    <div class="flex mt-2 gap-x-2">
        <x-button primary label="Simpan" x-on:click="$wire.simpan" spinner />
    </div>
</div>
