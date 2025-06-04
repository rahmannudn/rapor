<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    {{-- show & search --}}
    <div class="block mb-4 space-y-2 md:flex md:items-center md:justify-between md:space-y-0 md:space-x-2">
        <div class="flex flex-row items-center space-x-2 md:w-[50%]">
            <div class="block md:w-20">
                <x-native-select label="Show" wire:model.change='show'>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-native-select>
            </div>
            <div class="w-52">
                <x-native-select label="Tahun Ajaran" placeholder="Pilih Tahun Ajaran"
                    wire:model.change="selectedTahunAjaran">
                    @if ($daftarTahunAjaran)
                        @foreach ($daftarTahunAjaran as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun }} - {{ $ta->semester }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
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
                    Rombel
                </th>
                <th scope="col" class="px-6 py-3">
                    Wali Kelas
                </th>
                <th scope="col" class="px-4 py-3">
                    Fase
                </th>
                <th scope="col" class="px-4 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelasData as $data)
                <tr wire:key="{{ $data->id }}"
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $kelasData->firstItem() + $loop->index }}
                    </th>

                    <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $data->nama }}
                    </th>
                    <th scope="row" class="px-6 py-3">
                        {{ $data->nama_guru ? $data->nama_guru : 'Belum ada Wali Kelas' }}
                    </th>
                    <td class="px-4 py-4">
                        {{ Str::upper($data->fase) }}
                    </td>
                    <td class="px-4 py-4">
                        @if ($data->tahun_ajaran_id === $tahunAjaranAktif)
                            @can('isKepsek', auth()->user())
                                <x-button href="{{ route('kelasConfig', ['kelasData' => $data->id]) }}" wire:navigate
                                    class="mb-3" icon="cog" info label="Atur Rombel" />
                            @endcan

                            @can('isAdmin', auth()->user())
                                <div class="flex flex-row items-center justify-center space-x-2">
                                    <x-button.circle green icon="pencil-alt"
                                        href="{{ route('kelasEdit', ['kelasData' => $data->id]) }}" />
                                    <x-button.circle negative icon="trash"
                                        x-on:click="$dispatch('set-kelas', {{ $data->id }}); $openModal('deleteModal');" />
                                </div>
                            @endcan
                        @endif

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
        {{ $kelasData->links() }}
    </div>
</div>
