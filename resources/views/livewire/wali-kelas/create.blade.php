<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Tambah Wali Kelas
    </x-slot:title> <x-button href="{{ route('waliKelasIndex') }}" wire:navigate class="mb-1" icon="arrow-left"
        info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Wali Kelas</h1>

    <x-native-select class="max-w-72" label="Kelas" placeholder="Pilih Kelas" wire:model.defer="kelas">
        <option value="">--Pilih Kelas--</option>
        @foreach ($daftarKelas as $kelas)
            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
        @endforeach
    </x-native-select>

    <x-native-select class="max-w-72" label="Guru" placeholder="Pilih Guru" wire:model.defer="guru">
        <option value="">--Pilih Guru--</option>
        @foreach ($daftarGuru as $guru)
            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
        @endforeach
    </x-native-select>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('waliKelasIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
