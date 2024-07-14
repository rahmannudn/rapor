<div>
    @if ($formCreate)
        <x-button href="{{ route('catatanProyekEdit') }}" wire:navigate class="mb-3" icon="plus" info
            label="Edit Catatan" />
    @endif

    <div class="flex flex-col w-full space-y-2 md:flex-row md:space-x-2 md:items-center md:space-y-0">
        @can('viewAny', \App\Models\CapaianFase::class)
            <div class="w-52">
                <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="selectedKelas"
                    x-on:change="$wire.getCatatan">
                    <option value="">--Pilih Kelas--</option>
                    @if ($daftarKelas)
                        @foreach ($daftarKelas as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="w-52">
                <x-native-select label="Tahun Ajaran" placeholder="Pilih Tahun Ajaran" wire:model.defer="tahunAjaranAktif">
                    @if ($daftarTahunAjaran)
                        @foreach ($daftarTahunAjaran as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun }} - {{ $ta->semester }}</option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>
        @endcan
    </div>

    @if ($formCreate)
        <div class="mb-2 space-y-4">
            <div class="space-y-2">
            </div>
        </div>
    @endif

    <div class="flex justify-between my-2 gap-x-4">
        <div class="flex gap-x-2">
            @if (!$formCreate)
                <x-button primary label="Tampilkan Form" x-on:click="$wire.showForm" spinner />
            @endif
        </div>
    </div>
</div>
