<div>
    <style>
        .custom-container {
            max-width: 1280px;
            /* Sesuaikan dengan ukuran maksimum yang diinginkan */
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            /* Sesuaikan padding */
            padding-right: 1rem;
        }
    </style>
    <!-- Topbar -->
    <header class="flex justify-end p-4">
        <a href="{{ route('login') }}"
            class="px-5 py-2 text-white transition rounded-full shadow-md bg-slate-600 hover:bg-slate-800">
            Login
        </a>
    </header>

    <!-- Hero Section -->
    <main class="relative flex items-center h-screen bg-blue-100" id="hero">
        <div class="flex flex-col items-center mx-auto custom-container lg:flex-row">
            <!-- Text Content -->
            <div class="text-center lg:w-1/2 lg:text-left">
                <h2 class="text-4xl font-bold leading-tight text-blue-700 md:text-6xl">
                    Selamat Datang di <br>Aplikasi Rapor
                </h2>
                <p class="mt-6 text-lg text-gray-600">
                    Aplikasi ini mempermudah staf sekolah dalam mengelola rapor siswa dan memberikan akses mudah
                    bagi orang tua untuk memantau perkembangan anak.
                </p>
                <div class="flex justify-center mt-8 lg:justify-start">
                    <a href="#form-section"
                        class="px-6 py-3 text-white transition bg-blue-500 rounded-full shadow-lg hover:bg-blue-600">
                        Lihat Rapor Anak
                    </a>
                </div>
            </div>

            <!-- Image Content -->
            <div class="flex justify-center mt-12 lg:w-1/2 lg:mt-0">
                <img src="https://img.freepik.com/free-vector/school-student-online-education_52683-37481.jpg"
                    alt="Ilustrasi Sekolah" class="w-full max-w-md rounded-lg shadow-lg lg:max-w-lg">
            </div>
        </div>
    </main>

    <!-- Form Section -->
    <section class="flex items-center justify-center h-screen" id="form-section">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
            <h1 class="mb-6 text-2xl font-bold text-center text-blue-700">Form Rapor Anak</h1>
            <form action="/submit-form" method="POST">
                <!-- Input NISN -->
                <div class="mb-4">
                    <label for="nisn" class="block mb-2 font-medium text-gray-700">NISN Siswa</label>
                    <input type="text" id="nisn" wire:model='nisn'
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan NISN Siswa" required>
                    @error('nisn')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Tanggal Lahir -->
                <div class="mb-4">
                    <label for="tanggal_lahir" class="block mb-2 font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" wire:model='tgl_lahir'
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('tgl_lahir')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Tempat Lahir -->
                <div class="mb-4">
                    <label for="tempat_lahir" class="block mb-2 font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" wire:model='tempat_lahir'
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan Tempat Lahir" required>
                    @error('tempat_lahir')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @if (session('errorMessage'))
                    <p class="mb-2 text-sm text-red-500">{{ session('errorMessage') }}</p>
                @endif

                {{-- <!-- Input Nomor Telepon -->
                <div class="mb-4">
                    <label for="nomor_telepon" class="block mb-2 font-medium text-gray-700">Nomor Telepon
                        Terdaftar</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan Nomor Telepon Terdaftar" required>
                </div>

                <!-- Input Kode OTP -->
                <div class="mb-6">
                    <label for="kode_otp" class="block mb-2 font-medium text-gray-700">Kode OTP</label>
                    <input type="text" id="kode_otp" name="kode_otp"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan Kode OTP" required>
                </div> --}}

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-2 text-white transition bg-blue-500 rounded-lg hover:bg-blue-600"
                    wire:click.prevent='cariSiswa'>Submit</button>
            </form>
        </div>
    </section>
</div>
