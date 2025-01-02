<div>
    @section('table-responsive')
        <link rel="stylesheet" href="{{ asset('resources/css/responsive-table.css') }}">
    @endsection
    <x-slot:title>
        Detail Proyek
    </x-slot:title>

    <x-button href="{{ url()->previous() }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />

    {{-- proyek info --}}
    <div class="relative overflow-x-auto w-[55%] mb-4 mt-2">
        <table
            class="w-full text-sm text-left text-gray-500 border border-gray-400 shadow-md rtl:text-right dark:text-gray-400 sm:rounded-lg">
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Judul Proyek
                </th>
                <td class="px-6 py-1">
                    {{ Str::limit($proyek['judul_proyek'], 70, '...') }}
                </td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Deskripsi Proyek
                </th>
                <td class="px-6 py-1">
                    {{ Str::limit($proyek['deskripsi'], 70, '...') }}
                </td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Wali Kelas
                </th>
                <td class="px-6 py-1">
                    {{ $nama_wali_kelas }}
                </td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Kelas
                </th>
                <td class="px-6 py-1">
                    {{ $nama_kelas }}
                </td>
            </tr>
            <tr class="border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Tahun Ajaran
                </th>
                <td class="px-6 py-1">
                    {{ $tahun }} - {{ $semester }}
                </td>
            </tr>
        </table>
    </div>
    {{-- proyek info --}}

    {{-- subproyek table --}}
    <h2 class="mb-4 text-2xl font-bold">Subproyek</h2>

    <div class="container">
        <table class="w-full responsive-table">
            <thead class="head-style">
                <tr>
                    <th class="cell-border black-text sticky-cell">NO</th>
                    <th class="cell-border black-text sticky-cell">Dimensi</th>
                    <th class="cell-border black-text ">Subelemen</th>
                    <th class="cell-border black-text ">Elemen</th>
                    <th class="cell-border black-text ">Capaian Fase</th>
                </tr>
            </thead>
            <tbody class="w-full">
                @forelse($subproyek as $item)
                    <tr key="{{ $loop->index }}" class="h-20 text-center">
                        <td class="px-1  w-[5%] text-center cell-border sticky-cell">
                            {{ $loop->index + 1 }}
                        </td>
                        <td scope="row" class="px-6 font-medium cell-border sticky-cell">
                            {{ $item['dimensi_deskripsi'] }}
                        </td>
                        <td scope="row" class="px-6 font-medium cell-border ">
                            {{ $item['elemen_deskripsi'] }}
                        </td>
                        <td scope="row" class="px-6 font-medium cell-border ">
                            {{ $item['subelemen_deskripsi'] }}
                        </td>
                        <td scope="row" class="px-6 font-medium cell-border ">
                            {{ $item['capaian_fase_deskripsi'] }}
                        </td>
                    </tr>
                @empty
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cell-border">
                        <th scope="row"
                            class="block px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Data Tidak Ditemukan
                        </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- subproyek table --}}


</div>
