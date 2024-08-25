<div>
    <p class="text-red-500 dark:bg-gray-800 dark:border-gray-700">*Kosongi kolom jika tidak mengikuti ekskul</p>
    <p class="text-gray-900 dark:bg-gray-800 dark:border-gray-700">{{ $namaKelas }}</p>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-center text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-1 py-3 w-[5%]" rowspan="2">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 w-64" rowspan="2">
                        Nama Siswa
                    </th>
                    <th scope="col" class="px-4 py-3 w-36">
                        Pilihan Ekskul 1
                    </th>
                    <th scope="col" class="px-4 py-3 w-48">
                        Deskripsi Ekskul 1
                    </th>
                    <th scope="col" class="px-4 py-3 w-36">
                        Pilihan Ekskul 2
                    </th>
                    <th scope="col" class="px-4 py-3 w-48">
                        Deskripsi Ekskul 2
                    </th>
                    <th scope="col" class="px-4 py-3 w-36">
                        Pilihan Ekskul 3
                    </th>
                    <th scope="col" class="px-4 py-3 w-48">
                        Deskripsi Ekskul 3
                    </th>
                    <th scope="col" class="px-4 py-3 w-36">
                        Pilihan Ekskul 4
                    </th>
                    <th scope="col" class="px-4 py-3 w-48">
                        Deskripsi Ekskul 4
                    </th>
                </tr>
            </thead>
            <tbody class="w-full">
                @forelse($siswaData as $index => $data)
                    <tr key="{{ $data['id'] }}"
                        class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-1 py-4 w-[5%]">
                            {{ $loop->index + 1 }}
                        </td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white w-64">
                            {{ $data['nama_siswa'] }}
                        </th>
                        @for ($i = 0; $i < 4; $i++)
                            <td scope="col" class="px-4 py-3 w-36">
                                <x-select class="max-w-72" placeholder="Pilih Ekskul"
                                    wire:model.defer="eskuls.{{ $index }}.{{ $i }}">
                                    @foreach ($daftarEkskul as $value)
                                        <x-select.option value="{{ $value['id'] }}"
                                            label="{{ $value['nama_ekskul'] }}" />
                                    @endforeach
                                </x-select>
                            </td>
                            <td scope="col" class="px-4 py-3 w-48">
                                <x-textarea class="text-black" />
                            </td>
                        @endfor
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
    </div>
    <div class="flex gap-x-2 mt-2">
        <x-button primary label="Simpan" x-on:click="$wire.simpan" spinner />
    </div>
</div>
