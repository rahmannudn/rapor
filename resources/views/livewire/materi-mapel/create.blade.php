<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Materi Mapel
    @endsection
    <x-button href="{{ route('materiMapelIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Materi Mapel</h1>
    @can('isSuperAdmin', Auth::id())
        <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">

            @can('isSuperAdmin', Auth::id())
                <div class="w-52">
                    {{-- blade-formatter-disable --}}
                <x-native-select label="Guru" placeholder="Pilih Guru" wire:model.defer="selectedGuru" x-on:change="$wire.getKelas">
                    <option value="">--Pilih Guru--</option>
                    @foreach ($daftarGuru as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                    @endforeach
                </x-native-select>
                {{-- blade-formatter-enable --}}
                </div>
            @endcan
            <div class="w-52">
                <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                    x-on:change='$wire.getMapel'>
                    <option value="">--Pilih Kelas--</option>
                    @if ($selectedGuru)
                        @foreach ($daftarKelas as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="w-52">
                <x-native-select label="Mata Pelajaran" placeholder="Pilih Mapel" wire:model.defer="selectedMapel">
                    <option value="">--Pilih Mapel--</option>
                    @if ($selectedGuru && $selectedKelas)
                        @foreach ($daftarMapel as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
        </div>

    @endcan

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('materiMapelIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
