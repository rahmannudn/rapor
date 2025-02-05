<div x-on:set-kelas="$wire.selectedKelas = $event.detail">
    <x-slot:title>
        Rombel
    </x-slot>

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Daftar Rombel</h1>

    @can('isAdminOrKepsek')
        <x-button href="{{ route('kelasCreate') }}" wire:navigate class="mb-3" icon="plus" info label="Tambah Rombel" />
    @endcan
    {{-- <x-button href="{{ route('guruMapelCreate') }}" wire:navigate class="mb-3" icon="plus" positive
        label="Tambah Guru Mapel" /> --}}

    <x-modal blur wire:model.defer="deleteModal" x-on:close="$wire.selectedKelas = null">
        <x-card title="Delete Note">
            <p class="text-gray-600">
                Anda Yakin Ingin Menghapus?
            </p>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button negative icon="trash" x-on:click='$wire.destroy' spinner label="Hapus" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <livewire:kelas.table />
</div>
