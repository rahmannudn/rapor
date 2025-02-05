<div>
    <x-slot:title>
        Edit Catatan Proyek
    </x-slot>

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Catatan Proyek</h1>

    {{-- <x-button href="{{ route('catatanProyekIndex') }}" wire:navigate class="mb-3" icon="arrow-left" info
        label="Kembali" /> --}}

    {{-- <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
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
    </div> --}}

    <div class="relative overflow-x-auto w-[55%] mb-4 mt-2">
        <table
            class="w-full text-sm text-left text-gray-500 border border-gray-400 shadow-md rtl:text-right dark:text-gray-400 sm:rounded-lg">
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Rombel
                </th>
                <td class="px-6 py-1">
                    {{ $kelasNama }}
                </td>
            </tr>
            <tr>
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Wali Kelas
                </th>
                <td class="px-6 py-1">
                    {{ $namaWaliKelas }}
                </td>
            </tr>
        </table>
    </div>

    <div class="mt-2 mb-2 space-y-4 overflow-x-auto">
        <table class="w-full text-sm text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200">
                <tr class="">
                    <th scope="col" class="w-5 px-2 py-3" rowspan="3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3" rowspan="3">
                        Nama
                    </th>
                    <th scope="col" class="px-4 py-3" colspan="{{ count($proyekData) }}">
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
                            <th scope="col" wire:key="{{ $data->id }}"
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
                    @forelse ($catatanSiswa as $siswaIndex => $data)
                        <tr wire:key="{{ $data['siswa_id'] }}"
                            class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-5 px-4 py-4">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="px-4 py-4">
                                {{ $data['nama_siswa'] }}
                            </td>
                            @foreach ($data['catatan_proyek'] as $catatanIndex => $catatan)
                                {{-- x-data="{
                                    initialValue: '',
                                    checkAndUpdate() {
                                        if (this.initialValue !== this.$refs.catatanValue.value.trim() && this.$refs.catatanValue.value.trim() !== '') {
                                            this.initialValue = this.$refs.catatanValue.value.trim();
                                            $wire.update({{ $siswaIndex }}, '{{ $catatanIndex }}');
                                        }
                                    }
                                }"
                                x-init="() => {
                                    if ($refs.catatanTextarea && typeof $refs.catatanTextarea.value.trim() !== 'undefined') {
                                        this.initialValue = $refs.catatanTextarea.value.trim();
                                    }
                                }" --}}
                                <td class="px-4 py-4 border-l border-r dark:bg-gray-800 dark:border-gray-700">
                                    {{-- mengikat nilai dari text area ke variabel x-data diatas --}}
                                    <x-textarea x-ref="catatanValue"
                                        wire:model="catatanSiswa.{{ $siswaIndex }}.catatan_proyek.{{ $catatanIndex }}.catatan"
                                        wire:key="{{ $catatan['proyek_id'] }}" class="text-black" {{-- mengecek apakah text area ini tidak kosong, jika ya panggil fungsi update pada livewire --}}
                                        x-on:blur="$wire.update({{ $siswaIndex }},'{{ $catatanIndex }}')" />
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

    <div class="flex justify-between my-2 gap-x-4">
        <div class="flex gap-x-2">
            <x-button primary label="Simpan" x-on:click="$wire.save" spinner />
        </div>
    </div>
</div>
