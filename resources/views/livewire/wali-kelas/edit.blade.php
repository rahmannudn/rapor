<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Wali Kelas
    @endsection
    <x-button href="{{ route('waliKelasIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700 dark:text-white">Edit Wali Kelas : {{ $wali_kelas->kelas->nama }}
    </h1>

    <x-native-select class="max-w-72" label="Kelas" placeholder="Pilih Kelas" wire:model.defer="kelas" autofocus>
        @foreach ($daftarKelas as $kelas)
            <option wire:key='{{ $kelas->id }}' value="{{ $kelas->id }}"> {{ $kelas->nama }} </option>
        @endforeach
    </x-native-select>

    <x-native-select class="max-w-72" label="Guru" placeholder="Pilih Guru" wire:model.defer="guru">
        @foreach ($daftarGuru as $guru)
            <option wire:key="{{ $guru->id }}" value="{{ $guru->id }}">{{ $guru->name }}</option>
        @endforeach
    </x-native-select>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('waliKelasIndex') }}" wire:navigate secondary label="Cancel" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $wali_kelas }})" spinner />
        </div>
    </div>
</div>
