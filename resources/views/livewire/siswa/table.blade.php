<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="block mb-4 space-y-2 md:flex md:items-center md:justify-between md:space-y-0 md:space-x-2">
        <div class="block md:w-20">
            <x-native-select label="Show" wire:model.change='show'>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </x-native-select>
        </div>

        <div class="block md:w-80">
            <x-input icon="search" label="Search" wire:model.live.debounce.1500ms='searchQuery' />
        </div>
    </div>
    <table class="w-full text-sm text-center text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-1 py-3 w-[5%]">
                    No
                </th>
                <th scope="col" class="px-6 py-3 w-[10%]">
                    NISN
                </th>
                <th scope="col" class="px-4 py-3 w-[20%]">
                    Nama
                </th>
                <th scope="col" class="px-4 py-3 w-[5%]">
                    JK
                </th>
                <th scope="col" class="px-4 py-3 w-[10%]">
                    Kelas
                </th>
                <th scope="col" class="px-4 py-3 w-[10%]">
                    Agama
                </th>
                <th scope="col" class="px-4 py-3 w-[10%]">
                    Foto
                </th>

                @can('update', auth()->user())
                    <th scope="col" class="px-4 py-3 w-[10%]">
                        Action
                    </th>
                @endcan
            </tr>
        </thead>
        <tbody class="w-full">
            @forelse($siswaData as $data)
                <tr key="{{ $data->id }}"
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-1 py-4 w-[5%]">
                        {{ $siswaData->firstItem() + $loop->index }}
                    </td>
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white w-[10%]">
                        {{ $data->nisn }}
                    </th>
                    <td class="px-4 py-4 w-[20%]">
                        {{ ucfirst($data->nama) }}
                    </td>
                    <td class="px-4 py-4 w-[5%]">
                        {{ Str::upper($data->jk) }}
                    </td>
                    <td class="px-4 py-4 w-[10%]">
                        {{ $data->nama_kelas }}
                    </td>
                    <td class="px-4 py-4 w-[10%]">
                        {{ ucfirst($data->agama) }}
                    </td>
                    <td class="px-4 py-4 w-[10%]">
                        @if ($data->foto)
                            <a href="{{ url('storage/' . $data->foto) }}" target="_blank">
                                <x-avatar size="w-20" squared src="{{ url('storage/' . $data->foto) }}" />
                            </a>
                        @else
                            <x-badge negative label="Tidak ada foto" />
                        @endif
                    </td>

                    @can('update', auth()->user())
                        <td class="px-4 py-4 space-x-2 w-[10%]">
                            <x-button.circle green icon="pencil-alt" href="{{ route('siswaEdit', ['siswa' => $data]) }}"
                                wire:navigate />
                            <x-button.circle negative icon="trash"
                                x-on:click="$dispatch('set-siswa',{{ $data->id }}); $openModal('deleteModal');" />
                        </td>
                    @endcan

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
        {{ $siswaData->links() }}
    </div>
</div>
