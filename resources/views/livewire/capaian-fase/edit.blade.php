<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Capaian Fase
    @endsection

    <x-button href="{{ route('capaianFaseIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Capaian Fase</h1>

    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            <x-textarea label="Dimensi Deskripsi" wire:model="dimensiDeskripsi" disabled />
            <x-textarea label="Elemen Deskripsi" wire:model="elemenDeskripsi" disabled />
            <x-textarea label="Sub Elemen Deskripsi" wire:model="subelemenDeskripsi" disabled />
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
