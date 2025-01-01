<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    <x-slot:title>
        Sekolah
    </x-slot:title> {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}
    <h1 class="text-2xl font-bold text-slate-700 dark:text-white">Data Sekolah</h1>
    <x-button href="{{ route('sekolahEdit') }}" wire:navigate class="" icon="pencil-alt" info
        label="Edit Data Sekolah" />

    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Sekolah <span class="float-right">:</span>
        </p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->nama_sekolah }}
        </p>
        </h2>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Alamat Sekolah <span
                class="float-right">:</span></p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->alamat_sekolah }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Kode Pos <span
                class="float-right">:</span></p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->kode_pos }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Kelurahan<span
                class="float-right">:</span></p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->kelurahan }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Kecamatan <span
                class="float-right">:</span></p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->kecamatan }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Kota <span class="float-right">:</span>
        </p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->kota }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Provinsi <span
                class="float-right">:</span></p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->provinsi }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">Email <span class="float-right">:</span>
        </p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->email }}
        </p>
    </div>
    <div class="flex items-center justify-start space-x-4">
        <p class="text-base font-medium text-gray-800 dark:text-white md:w-32">NSS <span class="float-right">:</span>
        </p>
        <p class="text-base font-medium text-gray-800 dark:text-white">
            {{ $dataSekolah->nss }}
        </p>
    </div>
</div>
</div>
