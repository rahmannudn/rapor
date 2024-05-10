<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Tahun Ajaran
    @endsection
    <x-button href="{{ route('tahunAjaranIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Tahun Ajaran</h1>

    <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
        <x-native-select wire:model='tahunAwal' label="Tahun Awal" autofocus>
            <option value="">-- Pilih tahun Awal --</option>

            @foreach ($years as $year)
                <option wire:key='{{ $loop->index }}' value="{{ $year }}">{{ $year }}
                </option>
            @endforeach
        </x-native-select>

        <x-native-select wire:model='tahunAkhir' label="Tahun Akhir">
            <option value="">-- Pilih tahun Akhir --</option>

            @foreach ($years as $year)
                <option wire:key='{{ $loop->index }}' value="{{ $year }}">{{ $year }}
                </option>
            @endforeach
        </x-native-select>

        <x-native-select wire:model='semester' label="Semester" class="mb-2">
            <option value="" selected>-- Pilih semester --</option>

            <option value="ganjil">Ganjil</option>
            <option value="genap">Genap</option>
        </x-native-select>

        <x-native-select wire:model='semesterAktif' label="Semester Aktif">
            <option value="" selected>-- Pilih Keaktifan Tahun Ajaran --</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </x-native-select>
    </div>


    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('tahunAjaranIndex') }}" secondary label="Cancel" x-on:click="close" />
            <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
        </div>
    </div>
</div>
