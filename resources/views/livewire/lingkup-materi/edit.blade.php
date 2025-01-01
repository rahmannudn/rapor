<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Edit Lingkup Materi
    </x-slot:title> {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
  {{-- blade-formatter-enable --}}

    <x-button href="{{ route('lingkupMateriIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info
        label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Lingkup Materi</h1>

    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            <x-input label="Mata Pelajaran" wire:model='namaMapel' disabled />
            <x-input label="Kelas" wire:model='kelas' disabled />
            <x-input label="Guru" wire:model='namaGuru' disabled />

            <x-textarea label="Lingkup Materi" placeholder="Masukkan Lingkup Materi" wire:model="deskripsi" autofocus />
        </div>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('lingkupMateriIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $lingkupMateri->id }})" spinner />
        </div>
    </div>
</div>
