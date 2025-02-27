<div>
    <div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
        <x-slot:title>
            Edit Prestasi
        </x-slot:title> <x-button href="{{ route('prestasiIndex') }}" wire:navigate class="mb-1" icon="arrow-left"
            info label="Kembali" />
        <h1 class="mb-1 text-2xl font-bold text-slate-700">Edit Prestasi</h1>

        <div class="mb-2 space-y-4">
            <x-native-select class="max-w-72" label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                x-on:change="$wire.getSiswa()" autofocus>
                <option value=""> --Pilih Kelas-- </option>
                @foreach ($daftarKelas as $kelas)
                    <option value="{{ $kelas->id }}"> {{ $kelas->nama }} </option>
                @endforeach
            </x-native-select>

            <x-native-select class="max-w-80" label="Siswa" placeholder="Pilih Siswa" wire:model.defer="selectedSiswa">
                @if ($selectedKelas && $daftarSiswa)
                    @foreach ($daftarSiswa as $siswa)
                        <option value="{{ $siswa['id'] }}">{{ $siswa['nama'] }}</option>
                    @endforeach
                @endif
            </x-native-select>

            <x-input label="Nama Prestasi" placeholder="Masukkan Nama Pertasi" wire:model='namaPrestasi' />
            <div class="max-w-72">
                <x-datetime-picker label="Tanggal Prestasi" placeholder="Masukkan Tanggal Prestasi"
                    display-format="DD-MM-YYYY" wire:model.defer="tglPrestasi" without-time="true"
                    without-tips="true" />
            </div>
            <x-input label="Penyelenggara" placeholder="Masukkan Nama Penyelenggara" wire:model='penyelenggara' />
            <x-textarea wire:model="deskripsi" label="Deskripsi" />
            <div class="space-y-2">
                <p class="mb-2">Bukti</p>
                @if ($bukti)
                    <a href="{{ url('storage/' . $originBukti) }}" target="_blank">
                        <x-avatar size="w-50" squared src="{{ url('storage/' . $originBukti) }}" />
                    </a>
                @endif
                <x-input type="file" placeholder="Upload Bukti" wire:model='bukti' />
            </div>
            <x-input label="Nilai Prestasi" placeholder="Masukkan Nilai Pertasi" wire:model='nilaiPrestasi' />
        </div>
        <div class="flex justify-between gap-x-4">
            <div class="flex gap-x-2">
                <x-button primary label="Save" x-on:click="$wire.update({{ $prestasiData }})" spinner />
            </div>
        </div>
    </div>
</div>
