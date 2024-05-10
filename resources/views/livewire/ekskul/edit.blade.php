<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Ekskul
    @endsection
    <x-button href="{{ route('ekskulIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700 dark:text-white">Edit : {{ $namaEkskul }}
    </h1>

    <div class="mb-2 space-y-4">
        <x-input label="Nama Ekskul" placeholder="Masukkan Nama Ekskul" wire:model='namaEkskul' />
    </div>


    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('ekskulIndex') }}" wire:navigate secondary label="Cancel" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $ekskul }})" spinner />
        </div>
    </div>
</div>
