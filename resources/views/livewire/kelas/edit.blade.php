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
            <x-radio id="md" value="1" label="Kelas 1" wire:model.defer="kelas" />
            <x-radio id="md" value="2" label="Kelas 2" wire:model.defer="kelas" />
            <x-radio id="md" value="3" label="Kelas 3" wire:model.defer="kelas" />
            <x-radio id="md" value="4" label="Kelas 4" wire:model.defer="kelas" />
            <x-radio id="md" value="5" label="Kelas 5" wire:model.defer="kelas" />
            <x-radio id="md" value="6" label="Kelas 6" wire:model.defer="kelas" />
        </div>
        <div class="space-y-2">
            <p>Pilih Fase</p>
            <x-radio id="md" value="a" label="Fase A" wire:model.defer="fase" />
            <x-radio id="md" value="b" label="Fase B" wire:model.defer="fase" />
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
