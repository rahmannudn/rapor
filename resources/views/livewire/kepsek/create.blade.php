<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Kepsek
    @endsection
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
        <x-checkbox id="checkbox" left-label="Aktif" wire:model.defer="aktif" />
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('kepsekIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
