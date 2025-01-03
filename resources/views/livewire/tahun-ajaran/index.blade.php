<div x-on:set-tahun-ajaran="$wire.selectedTahunAjaran = $event.detail">
    <x-slot:title>
        Tahun Ajaran
    </x-slot:title>

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Tahun Ajaran</h1>

    <x-button href="{{ route('tahunAjaranCreate') }}" wire:navigate class="mb-3" icon="plus" info
        label="Tambah Tahun Ajaran" />

    <x-modal blur wire:model.defer="deleteModal" x-on:close="$wire.selectedTahunAjaran = null">
        <x-card title="Delete Note">
            <p class="text-gray-600">
                Anda Yakin Ingin Menghapus?
            </p>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button negative icon="trash" x-on:click='$wire.destroy()' spinner label="Hapus" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    {{-- TODO : MEMBUAT VALIDASI HANYA BOLEH SATU SEMESTER YANG AKTIF --}}
    <livewire:tahun-ajaran.table />
</div>
