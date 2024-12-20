<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    {{-- show & search --}}
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
    {{-- table --}}
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    NO
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="px-4 py-3">
                    Email
                </th>
                <th scope="col" class="px-4 py-3">
                    JK
                </th>
                <th scope="col" class="px-4 py-3">
                    Role
                </th>
                <th scope="col" class="px-4 py-3">
                    Jenis Pegawai
                </th>
                @can('isAdmin')
                    <th scope="col" class="px-4 py-3">
                        Action
                    </th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($userData as $data)
                <tr wire:key="{{ $data->id }}"
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-4 py-4">
                        {{ $userData->firstItem() + $loop->index }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ Str::ucfirst($data->name) }}
                    </th>
                    <td class="px-4 py-4">
                        {{ $data->email }}
                    </td>
                    <td class="px-4 py-4">
                        {{ $data->jk == 'l' ? 'Laki-Laki' : 'Perempuan' }}
                    </td>
                    <td class="px-4 py-4">
                        {{ Str::ucfirst($data->role) }}
                    </td>
                    <td class="px-4 py-4">
                        {{ Str::ucfirst($data->jenis_pegawai) }}
                    </td>
                    @can('isAdmin')
                        <td class="px-4 py-4">
                            <x-button.circle green icon="pencil-alt" href="{{ route('userEdit', ['user' => $data]) }}"
                                wire:navigate />
                            <x-button.circle negative icon="trash"
                                x-on:click="$dispatch('set-user', {{ $data->id }}); $openModal('deleteModal');" />
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
        {{ $userData->links() }}
    </div>
</div>
