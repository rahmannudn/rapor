<div>
    @if ($formCreate)
        <x-button href="{{ route('catatanProyekEdit') }}" wire:navigate class="mb-3" icon="plus" info
            label="Edit Catatan" />
    @endif

    <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        @can('viewAny', \App\Models\CapaianFase::class)
            <div class="w-52">
                <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                    x-on:change="$wire.getCatatan">
                    <option value="">--Pilih Kelas--</option>
                    @if ($daftarKelas)
                        @foreach ($daftarKelas as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="w-52">
                <x-native-select label="Tahun Ajaran" placeholder="Pilih Tahun Ajaran" wire:model.defer="tahunAjaranAktif"
                    x-on:change="$wire.getCatatan">
                    @if ($daftarTahunAjaran)
                        @foreach ($daftarTahunAjaran as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun }} - {{ $ta->semester }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
        @endcan
    </div>

    @if ($formCreate)
        <div class="mt-2 mb-2 space-y-4 overflow-x-auto">
            <table class="w-full text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 ">
                    <tr class="">
                        <th scope="col" class="w-5 px-2 py-3" rowspan="3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3" rowspan="3">
                            Nama
                        </th>
                        <th scope="col" class="px-4 py-3" colspan="2">
                            Catatan Proses
                        </th>
                    </tr>
                    @if ($proyekData)
                        <tr>
                            @for ($i = 0; $i < count($proyekData); $i++)
                                <th scope="col"
                                    class="px-4 py-3 border-t border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    Proyek {{ $i + 1 }}
                                </th>
                            @endfor
                        </tr>
                        <tr class="">
                            @foreach ($proyekData as $data)
                                <th scope="col"
                                    class="px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    {{ $data->judul_proyek }}
                                </th>
                            @endforeach
                        </tr>
                    @else
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 border-t border-b border-l border-r border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                Proyek Tidak Ditemukan
                            </th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @if ($catatanSiswa)
                        @forelse ($catatanSiswa as $data)
                            <tr wire:key="{{ $data['siswa_id'] }}"
                                class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-5 px-4 py-4">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $data['nama_siswa'] }}
                                </td>
                                @foreach ($data['catatan_proyek'] as $key => $catatan)
                                    <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                                        {{ $catatan['catatan'] }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-4">
                                    Siswa Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    @endif

    <div class="flex justify-between my-2 gap-x-4">
        <div class="flex gap-x-2">
            @if (!$formCreate)
                <x-button primary label="Tampilkan Tabel" x-on:click="$wire.showForm" spinner />
            @endif
        </div>
    </div>
</div>
