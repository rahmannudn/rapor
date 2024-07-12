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

            @can('isSuperAdmin', Auth::id())
                <div class="max-w-52">
                    <x-native-select label="Tahun Ajaran" wire:model.change='selectedTahunAjaran' class="w-[30%]">
                        <option value="">Semua</option>
                        @foreach ($daftarTahunAjaran as $TA)
                            <option value="{{ $TA->id }}">{{ $TA->tahun }} {{ $TA->semester }}</option>
                        @endforeach
                    </x-native-select>
                </div>
            @endcan
            <div class="max-w-44">
                <x-native-select label="Rombel" wire:model.change='selectedKelas' class="w-[30%]">
                    <option value="">Semua</option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                    @endforeach
                </x-native-select>
            </div>
            <div class="max-w-44">
                <x-native-select label="Mapel" wire:model.change='selectedMapel' class="w-[30%]">
                    <option value="">Semua</option>
                    @foreach ($daftarMapel as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </x-native-select>
            </div>
        </div>

        <div class="block md:w-80">
            <x-input icon="search" label="Search" wire:model.live.debounce.1500ms='searchQuery' />
        </div>
    </div>
    {{-- table --}}
    <div class="overflow-x-auto">
        <table
            class="w-full overflow-scroll overflow-x-auto text-sm text-left text-gray-500 table-auto rtl:text-right dark:text-gray-400 text-wrap">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">
                        NO
                    </th>
                    @can('isSuperAdmin', Auth::id())
                        <th scope="col" class="px-4 py-3 ">
                            Guru
                        </th>
                    @endcan
                    <th scope="col" class="px-4 py-3 ">
                        Nama Mapel
                    </th>
                    <th scope="col" class="px-4 py-3 ">
                        Lingkup Materi
                    </th>
                    @can('isSuperAdmin', Auth::id())
                        <th scope="col" class="px-4 py-3 ">
                            Kelas
                        </th>
                        <th scope="col" class="px-4 py-3 ">
                            Tahun Ajaran
                        </th>
                    @endcan
                    <th scope="col" class="px-4 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataLM as $data)
                    <tr wire:key="{{ $data->id }}"
                        class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="col"
                            class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $dataLM->firstItem() + $loop->index }}
                        </th>
                        @can('isSuperAdmin', Auth::id())
                            <td class="px-4 py-4 overflow-hidden max-w-96 text-ellipsis">
                                {{ $data->nama_guru }}
                            </td>
                        @endcan
                        <td class="px-4 py-4 overflow-hidden text-ellipsis">
                            {{ $data->nama_mapel }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $data->lingkup_materi_deskripsi }}
                        </td>
                        @can('isSuperAdmin', Auth::id())
                            <td class="px-4 py-3 ">
                                {{ $data->nama_kelas }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $data->tahun }} - {{ $data->semester }}
                            </td>
                        @endcan
                        <td class="px-4 py-4">
                            <x-button.circle green icon="pencil-alt"
                                href="{{ route('lingkupMateriEdit', ['lingkupMateri' => $data->id]) }}"
                                wire:navigate />
                            <x-button.circle negative icon="trash"
                                x-on:click="$dispatch('set-lm', {{ $data->id }}); $openModal('deleteModal');" />
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
    </div>

    <div class="px-4 py-2 bg-slate-300">
        {{ $dataLM->links() }}
    </div>
</div>
