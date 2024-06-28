<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Elemen
    @endsection

    <x-button href="{{ route('elemenIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Elemen</h1>

    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            <x-textarea label="Dimensi Deskripsi" wire:model="dimensiDeskripsi" disabled />
            <x-input label="Deskripsi" placeholder="Masukkan Deskripsi" wire:model='deskripsi' autofocus />
        </div>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('elemenIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $elemen->id }})" spinner />
        </div>
    </div>

</div>
