<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Wali Kelas
    @endsection
    <x-button href="{{ route('waliKelasIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Wali Kelas</h1>

    <x-select class="max-w-72" label="Kelas" placeholder="Pilih Kelas" wire:model.defer="kelas" autofocus>
        @foreach ($daftarKelas as $kelas)
            <x-select.option value="{{ $kelas->id }}" label="{{ $kelas->nama }}" />
        @endforeach
    </x-select>

    <x-select class="max-w-72" label="Guru" placeholder="Pilih Guru" wire:model.defer="guru">
        @foreach ($daftarGuru as $guru)
            <x-select.option value="{{ $guru->id }}" label="{{ $guru->name }}" />
        @endforeach
    </x-select>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('waliKelasIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
