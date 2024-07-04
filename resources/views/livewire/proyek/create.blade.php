<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Proyek
    @endsection

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <x-button href="{{ route('proyekIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Data Proyek</h1>
    <p class="text-sm text-slate-700">Tahun Ajaran : {{ $tahunAjaranAktif['tahun'] }} -
        {{ $tahunAjaranAktif['semester'] }}
    </p>

    <div class="flex flex-col w-full space-y-2">
        <div class="w-52">
            <x-native-select label="Wali Kelas" placeholder="Pilih Wali Kelas" wire:model.defer="selectedWaliKelas">
                <option value="">--Pilih Wali Kelas--</option>
                @foreach ($daftarWaliKelas as $waliKelas)
                    <option wire:key="{{ $waliKelas->wali_kelas_id }}"
                        value="{{ $waliKelas->wali_kelas_id }}/{{ $waliKelas->kelas_id }}">
                        {{ $waliKelas->nama }} -
                        @can('isSuperAdmin', Auth::id())
                            {{ $waliKelas->nama_kelas }}
                        @endcan
                    </option>
                @endforeach
            </x-native-select>
        </div>
    </div>

    @if ($selectedWaliKelas && $createForm == 'true')
        <div class="mb-2 space-y-4">
            <div class="block md:flex md:items-center md:justify-between md:space-x-2">
                <x-native-select class="h-20" label="Dimensi" placeholder="Pilih Dimensi"
                    wire:model.defer="selectedDimensi" x-on:change="$wire.getElemen" autofocus>
                    <option value="">--Pilih Dimensi--</option>
                    @foreach ($daftarDimensi as $dimensi)
                        <option value="{{ $dimensi->id }}" class="w-full">
                            {{ Str::of($dimensi->deskripsi)->words('25', ' ...') }}
                        </option>
                    @endforeach
                </x-native-select>

                <x-native-select class="h-20" label="Elemen" placeholder="Pilih Elemen"
                    wire:model.defer="selectedElemen" x-on:change="$wire.getSubelemen">
                    <option value="">--Pilih Subelemen--</option>
                    @if ($selectedDimensi && $daftarElemen)
                        @foreach ($daftarElemen as $elemen)
                            <option value="{{ $elemen->id }}" class="w-full">
                                {{ Str::of($elemen->deskripsi)->words('25', ' ...') }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="block md:flex md:items-center md:justify-between md:space-x-2">
                <x-native-select class="h-20" label="Sub Elemen" placeholder="Pilih Sub Elemen"
                    wire:model.defer="selectedSubelemen" x-on:change="$wire.getCapaianFase">
                    <option value="">--Pilih Subelemen--</option>
                    @if ($selectedDimensi && $selectedElemen && $daftarSubelemen)
                        @foreach ($daftarSubelemen as $subelemen)
                            <option value="{{ $subelemen->id }}" class="w-full">
                                {{ Str::of($subelemen->deskripsi)->words('25', ' ...') }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>

                <div class="w-full">
                    <x-textarea class="h-20" wire:model="capaianFase" label="Capaian Fase" disabled />
                </div>

            </div>

            <div class="space-y-2">
                <x-input label="Judul Proyek" placeholder="Masukkan Judul Proyek" wire:model='judulProyek' />
                <x-textarea label="Deskripsi" placeholder="Masukkan Deskripsi" wire:model="deskripsi" />
            </div>
        </div>
    @endif

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            @if ($selectedWaliKelas && $createForm == 'true')
                <x-button href="{{ route('proyekIndex') }}" secondary label="Cancel" x-on:click="close" />
                <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
            @else
                <x-button primary label="Tampilkan Form" x-on:click="$wire.showForm" spinner />
            @endif
        </div>
    </div>


</div>
</div>
