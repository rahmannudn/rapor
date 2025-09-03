<div>
    <div class="block mb-4 space-y-2 md:flex md:items-center md:justify-between md:space-y-0 md:space-x-2">
        <div class="flex flex-row items-center space-x-2 md:w-[40%]">
            <div class="max-w-20">
                <x-native-select label="Show" wire:model.change='show'>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-native-select>
            </div>

            <div class="max-w-52">
                <x-native-select label="Tahun Ajaran" wire:model.change='selectedTahunAjaran' class="w-[30%]">
                    <option value="">Semua</option>
                    @foreach ($daftarTahunAjaran as $TA)
                        <option wire:key="{{ $TA->id }}" value="{{ $TA->id }}">
                            {{ $TA->tahun }}-{{ $TA->semester }}</option>
                    @endforeach
                </x-native-select>
            </div>

            @can('isKepsekOrWaliKelas', auth()->user())
                <x-button class="mt-6" icon="folder-download" red label="Download PDF"
                    x-on:click="window.open('{{ route('laporanProyekPDF', ['tahunAjaran' => $selectedTahunAjaran, 'query' => $searchQuery]) }}', '_blank')" />
            @endcan

            @can('isWaliKelas', auth()->user())
                <x-button class="mt-6" primary icon="folder-download" label="Download Excel"
                    x-on:click="$wire.exportExcel" />
            @endcan
        </div>

        <div class="block md:w-80">
            <x-input icon="search" label="Search" wire:model.live.debounce.1500ms='searchQuery' />
        </div>
    </div>
    {{-- table --}}
    <div class="overflow-x-auto">
        <table
            class="w-full overflow-scroll overflow-x-auto text-sm text-left text-gray-500 table-auto rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">
                        NO
                    </th>
                    <th scope="col" class="px-4 py-3 max-w-96">
                        Judul Proyek
                    </th>
                    <th scope="col" class="px-4 py-3 ">
                        Deskripsi
                    </th>
                    @can('isKepsek', Auth::id())
                        <th scope="col" class="px-4 py-3 ">
                            Nama Guru
                        </th>
                    @endcan
                    <th scope="col" class="px-4 py-3 ">
                        Kelas
                    </th>
                    <th scope="col" class="px-4 py-3 ">
                        Tahun Ajaran
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarProyek as $proyek)
                    <tr wire:key="{{ $proyek->materi_mapel_id }}"
                        class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $daftarProyek->firstItem() + $loop->index }}
                        </th>
                        <td scope="col" class="px-4 py-4">
                            <a class="text-blue-800 underline"
                                href="{{ route('proyekDetail', ['proyek' => $proyek]) }}">{{ $proyek->judul_proyek }}</a>
                        </td>
                        <td scope="col" class="px-4 py-4 max-w-96">
                            {{ Str::of($proyek->deskripsi)->words('25', ' ...') }}
                        </td>
                        @can('isKepsek', Auth::id())
                            <td scope="col" class="px-4 py-4">
                                {{ $proyek->nama_guru }}
                            </td>
                        @endcan
                        <td scope="col" class="px-4 py-4">
                            {{ $proyek->nama_kelas }}
                        </td>
                        <th scope="col" class="px-4 py-3 ">
                            {{ $proyek->tahun }}-{{ $proyek->semester }}
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
    </div>

    <div class="px-4 py-2 bg-slate-300">
        {{ $daftarProyek->links() }}
    </div>
</div>
