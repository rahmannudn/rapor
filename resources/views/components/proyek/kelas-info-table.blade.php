<div class="relative overflow-x-auto w-[55%] mb-4 mt-2">
    <table
        class="w-full text-sm text-left text-gray-500 border border-gray-400 shadow-md rtl:text-right dark:text-gray-400 sm:rounded-lg">
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th scope="row"
                class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                Judul Proyek
            </th>
            <td class="px-6 py-1">
                {{ Str::limit($data['judul'], 70, '...') }}
            </td>
        </tr>
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th scope="row"
                class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                Kelas
            </th>
            <td class="px-6 py-1">
                {{ $data['namaKelas'] }}
            </td>
        </tr>
        @can('superAdminOrKepsek')
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Wali Kelas
                </th>
                <td class="px-6 py-1">
                    {{ $data['namaWaliKelas'] }}
                </td>
            </tr>
        @endcan
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th scope="row"
                class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                Fase
            </th>
            <td class="px-6 py-1">
                {{ $data['fase'] }}
            </td>
        </tr>
        <tr>
            <th scope="row"
                class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                Tahun Ajaran
            </th>
            <td class="px-6 py-1">
                {{ $data['tahunAjaran'] }}
            </td>
        </tr>
    </table>
</div>
