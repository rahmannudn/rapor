<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Edit Subelemen
    </x-slot:title>
    <x-button href="{{ route('subelemenIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Subelemen</h1>

    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            <div class="block md:flex md:items-center md:justify-between md:space-x-2">
                <x-native-select class="w-[35rem] h-20" label="Dimensi" placeholder="Pilih Dimensi"
                    wire:model.defer="selectedDimensi" x-on:change="$wire.getElemen">
                    <option value="">--Pilih Dimensi--</option>
                    @foreach ($daftarDimensi as $dimensi)
                        <option value="{{ $dimensi->id }}" class="w-full">
                            {{ Str::of($dimensi->deskripsi)->words('25', ' ...') }}
                        </option>
                    @endforeach
                </x-native-select>

                <x-native-select class="w-[35rem] h-20" label="Elemen" placeholder="Pilih Elemen"
                    wire:model.defer="selectedElemen">
                    <option value="">--Pilih Dimensi--</option>
                    @foreach ($daftarElemen as $elemen)
                        <option value="{{ $elemen->id }}" class="w-full">
                            {{ Str::of($elemen->deskripsi)->words('25', ' ...') }}
                        </option>
                    @endforeach
                </x-native-select>
            </div>
            <x-input label="Deskripsi" placeholder="Masukkan Deskripsi" wire:model='deskripsi' autofocus />
        </div>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('subelemenIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $subelemen->id }})" spinner />
        </div>
    </div>

</div>
