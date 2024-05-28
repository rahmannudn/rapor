<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Edit Pengguna
    @endsection
    <x-button href="{{ route('userIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700 dark:text-white">Edit : {{ $user->name }}
    </h1>

    <div class="mb-2 space-y-4">
        <x-input label="Nama User" placeholder="Masukkan Nama User" wire:model='name' autofocus />
        <x-input label="Email User" placeholder="Masukkan Email User" wire:model='email' />
        <x-inputs.password label="Password" placeholder="Masukkan Password" wire:model='password' />
        <x-native-select wire:model='role' label="Role">
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="kepsek">Kepala Sekolah</option>
        </x-native-select>
        <x-native-select wire:model='jk' label="Jenis Kelamin">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="l">Laki-Laki</option>
            <option value="p">Perempuan</option>
        </x-native-select>
        <x-native-select wire:model='jenis_pegawai' label="Jenis Pegawai">
            <option value="">-- Pilih Jenis Pegawai --</option>
            <option value="honor">Honor</option>
            <option value="pppk">PPPK</option>
            <option value="pns">PNS</option>
        </x-native-select>
    </div>


    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('kelasIndex') }}" wire:navigate secondary label="Cancel" />
            <x-button primary label="Save" x-on:click="$wire.update({{ $user }})" spinner />
        </div>
    </div>
</div>
