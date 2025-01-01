<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Tambah Kepsek
    </x-slot:title>
    @if (session('confirmDialog'))
        <x-modal blur wire:model.defer="confirmModal" x-on:close="$wire.confirmModal = false">
            <x-card title="Yakin mengubah kepsek aktif?">
                <div class="flex items-center space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 text-yellow-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-600 dark:text-white">
                        {{ session('confirmDialog')['message'] }}
                    </p>
                </div>

                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button warning wire:click="create({{ session('confirmDialog')['id'] }})" spinner
                            label="Save" />
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    @endif

    <x-button href="{{ route('kepsekIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Periode Kepsek</h1>

    <x-native-select class="max-w-72" label="Kepsek" placeholder="Pilih Kepsek" wire:model.defer="selectedKepsek">
        <option value="">--Pilih Kepsek--</option>
        @foreach ($daftarKepsek as $kepsek)
            <option wire.key="{{ $kepsek->id }}" value="{{ $kepsek->id }}">{{ $kepsek->name }}</option>
        @endforeach
    </x-native-select>

    <x-native-select class="max-w-72" label="Periode Awal" placeholder="Pilih Tahun Ajaran"
        wire:model.defer="periodeAwal">
        <option value="">--Pilih Tahun Ajaran--</option>
        @foreach ($daftarTahunAjaran as $tahun)
            <option wire.key="{{ $tahun->id }}" value="{{ $tahun->id }}">{{ $tahun->tahun }} -
                {{ $tahun->semester }}</option>
        @endforeach
    </x-native-select>

    <x-native-select class="max-w-72" label="Periode Akhir" placeholder="Pilih Tahun Ajaran"
        wire:model.defer="periodeAkhir">
        <option value="">--Pilih Tahun Ajaran--</option>
        @foreach ($daftarTahunAjaran as $tahun)
            <option wire.key="{{ $tahun->id }}" value="{{ $tahun->id }}">{{ $tahun->tahun }} -
                {{ $tahun->semester }}</option>
        @endforeach
    </x-native-select>

    <div class="space-y-2">
        <x-native-select class="max-w-72" wire:model='aktif' label="Aktif">
            <option value="" selected>-- Pilih Keaktifan Kepala Sekolah --</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </x-native-select>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('kepsekIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
