<div
    class="w-full p-4 mb-2 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Sekolah
    @endsection
    <x-button href="{{ route('sekolahIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />

    <h1 class="mb-1 text-2xl font-bold text-slate-700 dark:text-white">Edit Sekolah</h1>

    <div class="mb-2 space-y-4">
        <x-input label="NPSN" wire:model="npsn" />
        <x-input label="Nama Sekolah" wire:model="namaSekolah" />
        <x-textarea label="Alamat" wire:model='alamat' />
        <x-input label="Kode Pos" wire:model="kodePos" />
        <x-input label="Kelurahan" wire:model="kelurahan" />
        <x-input label="Kecamatan" wire:model="kecamatan" />
        <x-input label="Kota" wire:model="kota" />
        <x-input label="Provinsi" wire:model="provinsi" />
        <x-input label="Email" wire:model="email" />
        <x-input label="NSS" wire:model="nss" />
        <div class="space-y-2">
            <p>Logo Sekolah</p>
            @if ($originalLogo)
                <a href="{{ url('storage/' . $originalLogo) }}" target="_blank">
                    <x-avatar size="w-20" squared src="{{ url('storage/' . $originalLogo) }}" />
                </a>
            @endif
            <x-input type="file" accept="image/png, image/jpeg, image/jpg" placeholder="Upload Logo Sekolah"
                wire:model='logo' />
        </div>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('sekolahIndex') }}" wire:navigate secondary label="Cancel" />
            <x-button primary label="Save" x-on:click="$wire.update" x-on:shift.enter="$wire.update" spinner />
        </div>
    </div>
</div>
