<div>
    <x-slot:title>
        Detail Proyek
    </x-slot:title>

    <x-button href="{{ redirect()->back() }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />

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


</div>
