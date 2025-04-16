<div>
    <p class="mb-2 text-gray-900 dark:bg-gray-800 dark:border-gray-700">{{ $namaKelas }}</p>
    <div class="flex flex-col w-full mb-2 space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        <div class="w-52">
            <x-native-select class="max-w-48" label="Pilih Bulan" placeholder="Pilih Bulan"
                wire:model.change="selectedBulan" x-on:change="$wire.getSiswaData">{{-- todo --}}
                <option value="">--pilih bulan--</option>
                @foreach ($daftarBulan as $key => $bulan)
                    @dump($bulan)
                    <option wire.key="{{ $key }}" value="{{ $key }}">{{ $bulan }}</option>
                @endforeach
            </x-native-select>
        </div>
    </div>

    @if ($selectedBulan !== null)
        <div class="w-32 mt-4 mb-2 space-y-4">
            <x-inputs.maskable label="Jumlah Hari Efektif" type="number" mask="##" placeholder="1-31"
                wire:model='jumlahHariEfektif' x-on:blur="$wire.updateHari" />
        </div>
        <table class="w-full text-sm text-center text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-1 py-3 w-[5%]">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 w-[10%]">
                        Nama Siswa
                    </th>
                    <th scope="col" class="px-4 py-3 w-[25%]">
                        Sakit
                    </th>
                    <th scope="col" class="px-4 py-3 w-[25%]">
                        Izin
                    </th>
                    <th scope="col" class="px-4 py-3 w-[25%]">
                        Alfa
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
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white w-[10%]">
                            {{ $data['nama_siswa'] }}
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <x-inputs.maskable mask="###" wire:model="siswaData.{{ $index }}.sakit"
                                class="w-10" x-on:blur="$wire.update('{{ $index }}','sakit')" />
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <x-inputs.maskable mask="###" wire:model="siswaData.{{ $index }}.izin"
                                class="w-10" x-on:blur="$wire.update('{{ $index }}','izin')" />
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <x-inputs.maskable mask="###" wire:model="siswaData.{{ $index }}.alfa"
                                class="w-10" x-on:blur="$wire.update('{{ $index }}','alfa')" />
                        </th>
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

        <div class="flex mt-2 gap-x-2">
            <x-button primary label="Simpan" x-on:click="$wire.simpan" spinner />
        </div>
    @endif
</div>
