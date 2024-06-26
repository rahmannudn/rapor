<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Dimensi
    @endsection

    <x-button href="{{ route('dimensiIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Data Proyek</h1>

    <div>
        <x-native-select class="w-[35rem] h-20" label="Dimensi" placeholder="Pilih Dimensi"
            wire:model.defer="selectedDimensi">
            <option value="">--Pilih Dimensi--</option>
            @foreach ($daftarDimensi as $dimensi)
                <option value="{{ $dimensi->id }}" class="w-full">
                    {{ Str::of($dimensi->deskripsi)->words('25', ' ...') }}
                </option>
            @endforeach
        </x-native-select>
    </div>

    <div class="mb-2 space-y-4">
        <div class="space-y-2">
            @if ($createForm)
                <x-input label="Deskripsi" placeholder="Masukkan Deskripsi" wire:model='deskripsi' />
            @endif
        </div>
    </div>

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            @if ($createForm)
                <x-button href="{{ route('dimensiIndex') }}" secondary label="Cancel" x-on:click="close" />
                <x-button primary label="Save" x-on:click="$wire.save" x-on:shift.enter="$wire.save" spinner />
            @else
                <x-button primary label="Tampilkan Form" x-on:click="$wire.showForm" spinner />
            @endif
        </div>
    </div>

</div>
