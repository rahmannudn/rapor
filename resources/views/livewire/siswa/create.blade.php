<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Tambah Siswa
    </x-slot:title> <x-button href="{{ route('siswaIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info
        label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Data Siswa</h1>

    <div class="mb-2 space-y-4">
        <x-input type="number" label="NISN" placeholder="Masukkan NISN" wire:model='nisn' />
        <x-input type="number" label="NIDN/NIS" placeholder="Masukkan NIDN siswa" wire:model='nidn' />
        <x-input label="Nama Siswa" placeholder="Masukkan Nama Siswa" wire:model='nama' />
        <x-input label="Tempat Lahir" placeholder="Masukkan Tempat Lahir" wire:model='tempat_lahir' />
        <div class="max-w-72">
            <x-datetime-picker label="Tanggal Lahir" placeholder="Masukkan Tanggal Lahir" display-format="DD-MM-YYYY"
                wire:model.defer="tanggal_lahir" without-time="true" without-tips="true" />
        </div>
        <div class="space-y-2">
            <p>Pilih Jenis Kelamin</p>
            <x-radio id="laki-laki" value="l" label="Laki-Laki" wire:model="jk" />
            <x-radio id="perempuan" value="p" label="Perempuan" wire:model="jk" />
        </div>
        <div class="space-y-2">
            <p>Pilih Kelas</p>
            @foreach ($daftarKelas as $kelas)
                <x-radio wire:key="{{ $kelas->id }}" id="{{ $kelas->nama }}" value="{{ $kelas->id }}"
                    label="{{ $kelas->nama }}" wire:model="kelas_id" />
            @endforeach
        </div>

        <x-select class="max-w-72" label="Agama" placeholder="Pilih Agama" wire:model.defer="agama">
            <x-select.option value="islam" label="Islam" />
            <x-select.option value="kristen protestan" label="Kristen Protestan" />
            <x-select.option value="kristen katolik" label="Kristen Katolik" />
            <x-select.option value="hindu" label="Hindu" />
            <x-select.option value="buddha" label="Buddha" />
            <x-select.option value="konghucu" label="Konghucu" />
        </x-select>

        <x-textarea wire:model="alamat" label="Alamat" />
        <x-input label="Kelurahan" placeholder="Masukkan Kelurahan" wire:model='kelurahan' />
        <x-input label="Kecamatan" placeholder="Masukkan Kecamatan" wire:model='kecamatan' />
        <x-input label="Kota" placeholder="Masukkan Kota" wire:model='kota' />
        <x-input label="Provinsi" placeholder="Masukkan Provinsi" wire:model='provinsi' />
        <x-input label="Nama Ayah" placeholder="Masukkan Nama Ayah" wire:model='nama_ayah' />
        <x-input label="Nama Ibu" placeholder="Masukkan Nama Ibu" wire:model='nama_ibu' />
        <x-input type="number" label="Hp Ortu" placeholder="Masukkan Hp Ortu" wire:model='hp_ortu' />
        <x-input type="file" label="Foto Siswa" accept="image/png, image/jpeg, image/jpg"
            placeholder="Upload Foto Siswa" wire:model='foto' />
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('siswaIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" spinner />
        </div>
    </div>
</div>
