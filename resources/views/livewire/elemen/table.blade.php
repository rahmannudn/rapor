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
                    <th scope="col" class="px-4 py-3 ">
                        Dimensi
                    </th>
                    <th scope="col" class="px-4 py-3 ">
                        Elemen Deskripsi
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @forelse($elemenData as $elemen)
                    <tr wire:key="{{ $elemen->id }}"
                        class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->index + 1 }}
                        </th>
                        <td scope="col" class="px-4 py-4 max-w-[32rem]">
                            {{ Str::of($elemen->dimensiDeskripsi)->words('25', ' ...') }}
                        </td>
                        <td scope="col" class="px-4 py-4 max-w-[32rem]">
                            {{ Str::of($elemen->deskripsi)->words('25', ' ...') }}
                        </td>
                        <td class="px-4 py-4">
                            <x-button.circle green icon="pencil-alt"
                                href="{{ route('elemenEdit', ['elemen' => $elemen->id]) }}" wire:navigate />
                            <x-button.circle negative icon="trash"
                                x-on:click="$dispatch('set-elemen', {{ $elemen->id }}); $openModal('deleteModal');" />
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
        {{ $elemenData->links() }}
    </div>
</div>
