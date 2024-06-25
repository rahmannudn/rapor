<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Kelas
    @endsection
    <x-button href="{{ route('kelasIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700 dark:text-white">Edit : {{ $kelasData->nama }}
    </h1>

    <div class="mb-2 space-y-4">
        <x-input label="Nama Rombel" placeholder="Masukkan Nama Rombel" wire:model='nama' />
        <div class="space-y-2">
            <p>Pilih Jenjang</p>
            <x-radio id="kelas-1" value="1" label="Kelas 1" wire:model.defer="kelas" />
            <x-radio id="kelas-2" value="2" label="Kelas 2" wire:model.defer="kelas" />
            <x-radio id="kelas-3" value="3" label="Kelas 3" wire:model.defer="kelas" />
            <x-radio id="kelas-4" value="4" label="Kelas 4" wire:model.defer="kelas" />
            <x-radio id="kelas-5" value="5" label="Kelas 5" wire:model.defer="kelas" />
            <x-radio id="kelas-6" value="6" label="Kelas 6" wire:model.defer="kelas" />
        </div>
        <div class="space-y-2">
            <p>Pilih Fase</p>
            <x-radio id="fase-a" value="a" label="Fase A" wire:model.defer="fase" />
            <x-radio id="fase-b" value="b" label="Fase B" wire:model.defer="fase" />
            <x-radio id="fase-c" value="c" label="Fase C" wire:model.defer="fase" />
        </div>
    </div>


    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('kelasIndex') }}" wire:navigate secondary label="Cancel" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $kelasData }})"
                x-on:shift.enter="$wire.update({{ $kelas }})" spinner />
        </div>
    </div>
</div>
