<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Edit Capaian Fase
    </x-slot>

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <x-button href="{{ route('capaianFaseIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Capaian Fase</h1>

    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            <div class="block md:flex md:items-center md:justify-between md:space-x-2">
                <x-native-select class="h-20" label="Dimensi" placeholder="Pilih Dimensi"
                    wire:model.defer="selectedDimensi" x-on:change="$wire.getElemen">
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
            <div class="block md:flex md:items-center md:justify-between md:space-x-2 w-[50%]">
                <x-native-select class="h-20" label="Subelemen" placeholder="Pilih Subelemen"
                    wire:model.defer="selectedSubelemen">
                    <option value="">--Pilih Subelemen--</option>
                    @if ($selectedDimensi && $daftarElemen && $daftarSubelemen)
                        @foreach ($daftarSubelemen as $subelemen)
                            <option value="{{ $subelemen->id }}" class="w-full">
                                {{ Str::of($subelemen->deskripsi)->words('25', ' ...') }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
            <div class="space-y-2">
                <p>Pilih Fase</p>
                <x-radio id="fase a" value="a" label="Fase A" wire:model.defer="fase" />
                <x-radio id="fase b" value="b" label="Fase B" wire:model.defer="fase" />
                <x-radio id="fase c" value="c" label="Fase C" wire:model.defer="fase" />
            </div>
            <x-input label="Deskripsi" placeholder="Masukkan Deskripsi" wire:model='deskripsi' autofocus />
        </div>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('capaianFaseIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $capaianFase->id }})" spinner />
        </div>
    </div>

</div>
