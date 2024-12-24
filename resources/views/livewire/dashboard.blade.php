<div>
    @section('title')
        Dashboard
    @endsection

    @section('js')
        <script src="{{ $siswaPertahun->cdn() }}"></script>

        {{ $siswaPertahun->script() }}
    @endsection
    <div class="p-4 mt-5 border-2 border-gray-200 rounded-lg dark:border-gray-700">
        <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2 lg:grid-cols-3">
            <div class="w-full p-5 bg-white shadow-lg rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium tracking-wide text-gray-600">Jumlah Siswa</h2>
                        <p class="mt-2 text-4xl font-extrabold text-gray-700">{{ $jumlahSiswa }}</p>
                    </div>
                    <div class="p-2 text-white rounded-full bg-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            <path fill-rule="evenodd"
                                d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                clip-rule="evenodd" />
                            <path
                                d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="w-full p-5 bg-white shadow-lg rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium tracking-wide text-gray-600">Jumlah Pengguna</h2>
                        <p class="mt-2 text-4xl font-extrabold text-gray-700">{{ $jumlahPengguna }}</p>
                    </div>
                    <div class="p-2 text-white rounded-full bg-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="w-full p-5 bg-white shadow-lg rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium tracking-wide text-gray-600">Jumlah Rombel</h2>
                        <p class="mt-2 text-4xl font-extrabold text-gray-700">{{ $jumlahRombel }}</p>
                    </div>
                    <div class="p-2 text-white rounded-full bg-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="w-full p-5 bg-white shadow-lg rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium tracking-wide text-gray-600">Jumlah Eskul</h2>
                        <p class="mt-2 text-4xl font-extrabold text-gray-700">{{ $jumlahEkskul }}</p>
                    </div>
                    <div class="p-2 text-white rounded-full bg-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid items-center justify-between grid-cols-2 gap-4">
            {{-- data sekolah --}}
            <div class="p-4 py-8 space-y-4 text-black bg-white rounded-md">
                <h2 class="text-2xl font-bold">Data Sekolah</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold">Nama Sekolah</p>
                        <p>{{ $dataSekolah['nama_sekolah'] }}</p>
                        <p class="font-semibold">NPSN</p>
                        <p>{{ $dataSekolah['npsn'] }}</p>
                        <p class="font-semibold">Alamat</p>
                        <p>{{ $dataSekolah['alamat_sekolah'] }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Kepala Sekolah</p>
                        <p>{{ $kepalaSekolah['nama_kepsek'] }}</p>
                        <p class="font-semibold">NSS</p>
                        <p>{{ $dataSekolah['nss'] }}</p>
                        <p class="font-semibold">Kota</p>
                        <p>{{ $dataSekolah['kota'] }}, {{ $dataSekolah['kecamatan'] }}</p>
                        <p class="font-semibold">Kelurahan</p>
                        <p>{{ $dataSekolah['kelurahan'] }} ({{ $dataSekolah['kode_pos'] }})</p>
                        <p class="font-semibold">Provinsi</p>
                        <p>{{ $dataSekolah['provinsi'] }}</p>
                        <p class="font-semibold">Email</p>
                        <p>{{ $dataSekolah['email'] }}</p>
                    </div>
                </div>
            </div>
            {{-- data sekolah --}}

            {{-- rombel sekolah --}}
            <div class="w-full">
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead
                        class="text-xs text-center text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                NO
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Rombel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Wali Kelas
                            </th>
                            <th scope="col" class="px-4 py-3">
                                Fase
                            </th>
                            <th scope="col" class="px-4 py-3">
                                Jumlah Siswa
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jumlahSiswaPerRombel as $data)
                            <tr
                                class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->index + 1 }}
                                </th>

                                <th scope="row"
                                    class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $data->nama_kelas }}
                                </th>
                                <th scope="row" class="px-6 py-3">
                                    {{ $data->nama_wali_kelas ? $data->nama_wali_kelas : 'Belum ada Wali Kelas' }}
                                </th>
                                <td class="px-4 py-4">
                                    {{ Str::upper($data->fase) }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $data->jumlah_siswa }}
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
            {{-- rombel sekolah --}}
        </div>

        <div class="mt-4">
            {!! $siswaPertahun->container() !!}
        </div>
    </div>
</div>
