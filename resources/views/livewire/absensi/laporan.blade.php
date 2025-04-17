<div>
    <x-slot:title>
        Laporan Absensi
    </x-slot:title>
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Laporan Absensi</h1>

    {{-- <div class="mb-2 space-y-4">
        <x-native-select class="max-w-72" label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
            x-on:change="$wire.getSiswa()" autofocus>
            <option value=""> --Pilih Kelas-- </option>
            @foreach ($daftarKelas as $kelas)
                <option value="{{ $kelas->id }}"> {{ $kelas->nama }} </option>
            @endforeach
        </x-native-select>

        <x-native-select class="max-w-80" label="Siswa" placeholder="Pilih Siswa" wire:model.defer="selectedSiswa">
            <option value=""> --Pilih Siswa-- </option>
            @if ($selectedKelas && $daftarSiswa)
                @foreach ($daftarSiswa as $siswa)
                    <option value="{{ $siswa['id'] }}">{{ $siswa['nama'] }}</option>
                @endforeach
            @endif
        </x-native-select>
    </div> --}}
</div>
