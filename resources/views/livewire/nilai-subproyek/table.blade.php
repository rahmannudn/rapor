@section('sticky-header-table')
    <style>
        table thead {
            position: sticky;
        }

        table thead th:first-child {
            position: sticky;
            left: 0;
        }

        table tbody tr,
        table thead tr {
            position: relative;
        }

        table tbody th {
            position: sticky;
            left: 0;
        }
    </style>
@endsection
<div>
    <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        @can('viewAny', \App\Models\NilaiSubproyek::class)
            <div class="w-52">
                <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                    x-on:change="$wire.getDaftarProyek">
                    <option value="">--Pilih Kelas--</option>
                    @if ($daftarKelas)
                        @foreach ($daftarKelas as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            @can('superAdminOrKepsek')
                <div class="w-52">
                    <x-native-select label="Tahun Ajaran" placeholder="Pilih Tahun Ajaran" wire:model.defer="tahunAjaranAktif"
                        x-on:change="$wire.getDaftarProyek">
                        @if ($daftarTahunAjaran)
                            @foreach ($daftarTahunAjaran as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->tahun }} - {{ $ta->semester }}</option>
                            @endforeach
                        @endif
                    </x-native-select>
                </div>
            @endcan

            <div class="w-full md:w-[40%]">
                <x-native-select label="Proyek" placeholder="Pilih Proyek" wire:model.defer="selectedProyek"
                    x-on:change="$wire.getProyek">
                    @if ($daftarProyek)
                        @foreach ($daftarProyek as $proyek)
                            <option value="{{ $proyek['id'] }}">Proyek - {{ $loop->index + 1 }}
                                {{ $proyek['judul_proyek'] }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
        @endcan
    </div>

    @if ($showTable)
        <div class="md:flex md:items-center md:space-x-2">
            <x-proyek.kelas-info-table :data="$kelasInfo" />
            <x-proyek.keterangan-nilai-table />
        </div>

        <div class="w-full h-full mt-2 mb-2 space-y-4 overflow-auto">
            <table class="w-full overflow-scroll text-sm text-gray-500 table-auto rtl:text-right dark:text-gray-400">
                <thead class="sticky top-0 z-50 text-xs text-center text-gray-700 uppercase bg-gray-200 start-0 ">
                    <tr>
                        <th scope="col" class="w-5 px-2 py-3" rowspan="3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3" rowspan="3">
                            Nama Siswa
                        </th>
                        @if ($proyekData && count($proyekData) !== 0)
                            @foreach ($proyekData as $data)
                                <th colspan="4"
                                    class="w-64 px-4 py-4 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    {{ $data['dimensi_deskripsi'] }}</th>
                            @endforeach
                        @else
                            <th colspan="4" class="px-4 py-4 bg-red-400">Dimensi Tidak Ditemukan</th>
                        @endif
                    </tr>

                    @if ($proyekData)
                        <tr>
                            @foreach ($proyekData as $data)
                                <th scope="col" colspan="4"
                                    class="w-64 px-4 py-3 border-b border-l border-r border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    {{ $data['capaian_fase_deskripsi'] }}
                                </th>
                            @endforeach
                        </tr>

                        <tr>
                            @for ($i = 0; $i < count($proyekData); $i++)
                                <td
                                    class="px-2 py-2 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    BB
                                </td>
                                <td
                                    class="px-2 py-2 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    MB
                                </td>
                                <td
                                    class="px-2 py-2 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    BSH
                                </td>
                                <td
                                    class="px-2 py-2 border border-r-2 border-gray-300 border-r-gray-500 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                    SB
                                </td>
                            @endfor
                        </tr>
                    @endif
                </thead>

                <tbody>
                    @if ($nilaiData)
                        @forelse ($nilaiData as $nilaiIndex => $data)
                            <tr wire:key="{{ $data['siswa_id'] }}"
                                class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-5 px-4 py-4">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $data['nama_siswa'] }}
                                </td>
                                @if ($nilaiData && count($proyekData) !== 0)
                                    @foreach ($data['nilai'] as $key => $nilai)
                                        <td
                                            class="px-2 py-2 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                            <input value="bb" type="radio" wire:key="{{ $key }}"
                                                wire:model.defer="nilaiData.{{ $nilaiIndex }}.nilai.{{ $key }}.nilai"
                                                x-on:change="$wire.update({{ $nilaiIndex }},'{{ $key }}')" />
                                        </td>
                                        <td
                                            class="px-2 py-2 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                            <input value="mb" type="radio" wire:key="{{ $key }}"
                                                wire:model.defer="nilaiData.{{ $nilaiIndex }}.nilai.{{ $key }}.nilai"
                                                x-on:change="$wire.update({{ $nilaiIndex }},'{{ $key }}')" />
                                        </td>
                                        <td
                                            class="px-2 py-2 border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                            <input value="bsh" type="radio" wire:key="{{ $key }}"
                                                wire:model.defer="nilaiData.{{ $nilaiIndex }}.nilai.{{ $key }}.nilai"
                                                x-on:change="$wire.update({{ $nilaiIndex }},'{{ $key }}')" />
                                        </td>
                                        <td
                                            class="px-2 py-2 border border-r-2 border-gray-300 border-r-gray-500 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-700">
                                            <input value="sb" type="radio" wire:key="{{ $key }}"
                                                wire:model.defer="nilaiData.{{ $nilaiIndex }}.nilai.{{ $key }}.nilai"
                                                x-on:change="$wire.update({{ $nilaiIndex }},'{{ $key }}')" />
                                        </td>
                                    @endforeach
                                @endif
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
            @if (!$showTable)
                <x-button primary label="Tampilkan Tabel" x-on:click="$wire.showForm" spinner />
            @endif
        </div>
    </div>
</div>
