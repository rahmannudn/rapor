<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Tambah Pengguna
    </x-slot:title> <x-button href="{{ route('user.index') }}" wire:navigate class="mb-1" icon="arrow-left" info
        label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Pengguna</h1>

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
        <x-inputs.maskable label="NIP" wire:model="nip" mask="################" placeholder="Masukkan NIP" />
    </div>


    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('user.index') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
