<div class="w-full">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    NO
                </th>
                <th scope="col" class="px-6 py-3">
                    Rombel
                </th>
                <th scope="col" class="px-6 py-3">
                    Alfa
                </th>
                <th scope="col" class="px-4 py-3">
                    Sakit
                </th>
                <th scope="col" class="px-4 py-3">
                    Izin
                </th>
                <th scope="col" class="px-4 py-3">
                    Presentase Kehadiran
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensiKelas as $data)
                <tr
                    class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->index + 1 }}
                    </th>

                    <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $data['nama_kelas'] }}
                    </th>
                    <th scope="row" class="px-6 py-3">
                        {{ $data['total_alfa'] }}
                    </th>
                    <td class="px-4 py-4">
                        {{ $data['total_sakit'] }}
                    </td>
                    <td class="px-4 py-4">
                        {{ $data['total_izin'] }}
                    </td>
                    <td class="px-4 py-4">
                        <span
                            class="{{ warnaKehadiran($data['presentase_kehadiran']) }} text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm">
                            {{ $data['presentase_kehadiran'] }} %
                        </span>
                    </td>
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
