<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Edit Tahun Ajaran
    </x-slot:title>
    @if (session('confirmDialog'))
        <x-modal blur wire:model.defer="confirmModal" x-on:close="$wire.resetData">
            <x-card title="Yakin mengubah tahun ajaran aktif?">
                <div class="flex items-center space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 text-yellow-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-600 dark:text-white">
                        {{ session('confirmDialog')['message'] }}
                    </p>
                </div>

                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button warning x-on:click="$wire.update({{ session('confirmDialog')['id'] }})" spinner
                            label="Save" />
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    @endif

    <x-button href="{{ route('tahunAjaranIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info
        label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700 dark:text-white">Edit Tahun Ajaran : {{ $tahunAjaran->tahun }}
        {{ $tahunAjaran->semester }}</h1>

    <div class="grid grid-cols-1 gap-4 mb-2 sm:grid-cols-2">
        <x-native-select wire:model='tahunAwal' x-ref="tahun_awal" label="Tahun Awal" autofocus>
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
            @if ($tahunAjaran['aktif'] == 1)
                <option value="1" selected>Aktif</option>
            @else
                <option value="">-- Pilih Keaktifan Tahun Ajaran --</option>
                <option value="1" selected>Aktif</option>
                <option value="0">Tidak Aktif</option>
            @endif
        </x-native-select>

        <x-native-select wire:model='prevTahunAjaran' label="Tahun Ajaran Sebelumnya" class="mb-2">
            <option value="" selected>-- Pilih semester sebelumnya --</option>
            @foreach ($daftarTahunAjaran as $ta)
                <option wire:key='{{ $ta['id'] }}' value="{{ $ta['id'] }}">
                    {{ $ta['tahun'] }} - {{ Str::ucfirst($ta['semester']) }}
                </option>
            @endforeach
        </x-native-select>

        <div class="max-w-72">
            <x-datetime-picker label="Tanggal Pembagian Rapor" placeholder="Masukkan Tanggal rapor"
                display-format="DD-MM-YYYY" wire:model.defer="tgl_rapor" without-time="true" without-tips="true" />
        </div>

        <x-native-select wire:model='selectedKepsek' label="Kepsek Aktif" class="mb-2">
            <option value="" selected>-- Pilih Kepsek Aktif --</option>
            @foreach ($daftarKepsek as $kepsek)
                <option wire:key='{{ $kepsek['id'] }}' value="{{ $kepsek['id'] }}">
                    {{ $kepsek['nama_kepsek'] }}
                </option>
            @endforeach
        </x-native-select>
    </div>


    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            <x-button href="{{ route('tahunAjaranIndex') }}" wire:navigate secondary label="Cancel" />
            <x-button primary label="Save" x-on:click="$wire.edit({{ $tahunAjaran }})" spinner />
        </div>
    </div>
</div>
