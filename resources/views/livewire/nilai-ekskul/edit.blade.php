<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Edit Nilai Ekskul
    </x-slot:title> <x-button href="{{ route('nilaiEkskulIndex') }}" wire:navigate class="mb-1" icon="arrow-left"
        info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Nilai Ekskul : {{ $namaSiswa }}</h1>

    <div class="mb-2 space-y-4">
        <x-native-select wire:model='selectedSiswa' label="Pilih Siswa">
            <option value="">-- Pilih Siswa --</option>
            @foreach ($daftarSiswa as $siswa)
                <option value="{{ $siswa['kelas_siswa_id'] }}">{{ $siswa['nama_siswa'] }}</option>
            @endforeach
        </x-native-select>
        <x-native-select wire:model='selectedEkskul' label="Pilih Ekskul">
            <option value="">-- Pilih Ekskul --</option>
            @foreach ($daftarEkskul as $ekskul)
                <option value="{{ $ekskul['id'] }}">{{ $ekskul['nama_ekskul'] }}</option>
            @endforeach
        </x-native-select>
        <x-input label="Deskripsi" placeholder="Masukkan Deskripsi" wire:model='deskripsi' autofocus />
    </div>

    <x-button primary label="Save" x-on:click="$wire.update({{ $data }})" spinner />
</div>
