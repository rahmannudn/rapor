<div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
    @section('title')
        Tambah Data Guru Mapel
    @endsection

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <x-button href="{{ route('kelasIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />
    <h1 class="mb-1 text-2xl font-bold text-slate-700">Tambah Data Guru Mapel</h1>

    <div class="space-y-2">
        <div class="w-52">
            <x-native-select label="Kelas" placeholder="Pilih Kelas" wire:model.defer="kelas">
                <option value="">--Pilih Rombel--</option>
                @foreach ($daftarKelas as $dataKelas)
                    <option value="{{ $dataKelas->id }}">{{ $dataKelas->nama }}</option>
                @endforeach
            </x-native-select>
        </div>

        <x-button primary label="Tampilkan Mapel Kelas" x-on:click="$wire.showDaftarMapel" spinner />
    </div>


    @if ($kelas)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            {{-- table --}}
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead
                    class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            NO
                        </th>
                        <th scope="col" class="px-4 py-3 w-[30%]">
                            Mapel
                        </th>
                        <th scope="col" class="px-4 py-3 w-[60%]">
                            Pengajar
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataMapelDanPengajar as $index => $data)
                        <tr wire:key="{{ $data['id_mapel'] }}"
                            class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->index + 1 }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white w-[30%]">
                                {{ $data['nama_mapel'] }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                                <x-native-select placeholder="Pilih Guru"
                                    wire:model="dataMapelDanPengajar.{{ $index }}.id_user"
                                    x-on:change="$wire.setMapel('{{ $data['id_mapel'] }}')">
                                    <option value="">--Pilih Guru--</option>
                                    @foreach ($daftarGuru as $guru)
                                        <option wire:key="{{ $guru->id }}" value="{{ $guru->id }}">
                                            {{ $guru->name }}</option>
                                    @endforeach
                                </x-native-select>
                            </th>
                        </tr>
                    @empty
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="block px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Data Tidak Ditemukan
                            </th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <div class="flex justify-between gap-x-4">
        <div class="flex gap-x-2">
            @if ($kelas)
                <x-button primary label="Save" x-on:click="$wire.save" spinner />
            @endif
        </div>
    </div>
</div>
