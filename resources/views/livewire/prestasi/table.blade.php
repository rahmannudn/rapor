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
                <th scope="col" class="w-56 px-4 py-3">
                    Nama
                </th>
                <th scope="col" class="px-4 py-3 w-14">
                    Kelas Saat Ini
                </th>
                <th scope="col" class="w-56 px-4 py-3">
                    Nama Prestasi
                </th>
                <th scope="col" class="w-24 px-4 py-3">
                    Tanggal Prestasi
                </th>
                <th scope="col" class="w-48 px-4 py-3">
                    Penyelenggara
                </th>
                <th scope="col" class="px-4 py-3 w-[10%]">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="w-full">
            @forelse($siswaData as $data)
                <tr key="{{ $data->id }}"
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-1 py-4 w-[5%]">
                        {{ $siswaData->firstItem() + $loop->index }}
                    </td>
                    <td class="w-56 px-4 py-4">
                        {{ ucfirst($data->nama_siswa) }}
                    </td>
                    <td class="px-4 py-4 w-14">
                        {{ $data->nama_kelas }}
                    </td>
                    <td class="w-56 px-4 py-4">
                        {{ $data->nama_prestasi }}
                    </td>
                    <td class="w-24 px-4 py-3">
                        {{ \Carbon\Carbon::parse($data->tgl_prestasi)->translatedFormat('d F Y') }}
                    </td>
                    <td class="w-48 px-4 py-3">
                        {{ $data->penyelenggara }}
                    </td>
                    <td class="px-4 py-4 space-x-2 w-52">
                        <x-button.circle info icon="information-circle"
                            href="{{ route('prestasiDetail', ['prestasiData' => $data]) }}" wire:navigate />
                        <x-button.circle green icon="pencil-alt"
                            href="{{ route('prestasiEdit', ['prestasiData' => $data]) }}" wire:navigate />
                        <x-button.circle negative icon="trash"
                            x-on:click="$dispatch('set-prestasi',{{ $data->id }}); $openModal('deleteModal');" />
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
        {{ $siswaData->links() }}
    </div>
</div>
