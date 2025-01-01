<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Tambah Lingkup Materi
    </x-slot:title>
    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <x-button href="{{ route('lingkupMateriIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info
        label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Lingkup Materi</h1>

    <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        {{-- @can('isSuperAdmin', Auth::id())
            <div class="w-52">
                <x-native-select label="Guru" placeholder="Pilih Guru" wire:model.defer="selectedGuru"
                    x-on:change="$wire.getKelas">
                    <option value="">--Pilih Guru--</option>
                    @if ($daftarGuruMapel)
                        @foreach ($daftarGuruMapel as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
        @endcan --}}

        <div class="w-52">
            <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                x-on:change="$wire.getMapel">
                <option value="">--Pilih Kelas--</option>
                @if ($selectedGuru && $daftarKelas)
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                    @endforeach
                @endif
            </x-native-select>
        </div>

        <div class="w-52">
            <x-native-select label="Mata Pelajaran" placeholder="Pilih Mapel"
                wire:model.defer="selectedDetailGuruMapel">
                <option value="">--Pilih Mapel--</option>
                @if ($selectedGuru && $daftarMapel)
                    @foreach ($daftarMapel as $mapel)
                        {{-- menggunakan id detail sebagai value --}}
                        <option value="{{ $mapel->detail_guru_mapel_id }}">{{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                @endif
            </x-native-select>
        </div>
    </div>

    {{-- @if ($formCreate) --}}
    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            <x-textarea label="Lingkup Materi" placeholder="Masukkan Lingkup Materi" wire:model="deskripsi" />
        </div>
    </div>
    {{-- @endif --}}

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            {{-- @if ($formCreate) --}}
            <x-button href="{{ route('lingkupMateriIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
            {{-- @else
                <x-button primary label="Tampilkan Form" x-on:click="$wire.showForm" spinner />
            @endif --}}
        </div>
    </div>
</div>
