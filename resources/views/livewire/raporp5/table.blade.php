<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    {{-- show & search --}}
    <div class="block mb-4 space-y-2 md:flex md:items-center md:justify-between md:space-y-0 md:space-x-2">
        <div class="flex flex-row items-center space-x-2 md:w-[40%]">
            <div class="block md:w-20">
                <x-native-select label="Show" wire:model.change='show'>
                    {{-- <option value="">Semua</option> --}}
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-native-select>
            </div>

            <div class="max-w-52">
                <x-native-select label="Tahun Ajaran" wire:model.change='selectedTahunAjaran' class="w-[30%]">
                    @foreach ($daftarTahunAjaran as $TA)
                        <option value="{{ $TA->id }}">{{ $TA->tahun }} {{ $TA->semester }}</option>
                    @endforeach
                </x-native-select>
            </div>
        </div>

        <div class="block md:w-80">
            <x-input icon="search" label="Search" wire:model.live.debounce.1500ms='searchQuery' />
        </div>
    </div>
    {{-- table --}}
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    NO
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Siswa
                </th>
                <th scope="col" class="px-6 py-3">
                    Kelas
                </th>
                <th scope="col" class="px-4 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataSiswa as $siswa)
                <tr wire:key="{{ $siswa->id }}"
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $dataSiswa->firstItem() + $loop->index }}
                    </th>

                    <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $siswa->nama }}
                    </th>

                    <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $siswa->nama_kelas }}
                    </th>

                    <td class="px-4 py-4">
                        <x-button class="mb-3" icon="folder-download" info label="Download"
                            x-on:click="window.open('{{ route('cetakRaporP5', ['siswa' => $siswa]) }}', '_blank')" />
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
        {{ $dataSiswa->links() }}
    </div>
</div>
