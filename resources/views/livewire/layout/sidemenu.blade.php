<?php

use Livewire\Volt\Component;
use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Helpers\FunctionHelper;
use Illuminate\Support\Facades\Session;

new class extends Component {
    /**
     * Log the current user out of the application.
     */

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }

    public function mount()
    {
        FunctionHelper::setCacheTahunAjaran();
        FunctionHelper::setCacheInfoSekolah();
        // FunctionHelper::setCacheKepsekAktif();
    }

    // public function rendering()
    // {
    //     if (!Session::get('tahunAjaranAktif')) {
    //         FunctionHelper::setCacheTahunAjaran();
    //     }
    // }
}; ?>

<div>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-24 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto text-gray-900 bg-white rounded-lg dark:bg-gray-800 dark:text-white">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('userIndex') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('userIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="ms-3">Pengguna</span>
                    </a>
                </li>

                @can('superAdminOrAdmin', auth()->user())
                    <li x-data="{ dropdownMaster: false }">
                        <button type="button" x-on:click="dropdownMaster = !dropdownMaster"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>

                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Data Master</span>

                            <svg :class="dropdownMaster && 'hidden'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>

                            <svg :class="dropdownMaster || 'hidden'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>
                        <ul x-show="dropdownMaster" class="py-2 space-y-2" x-transition>
                            <li>
                                <a href="{{ route('sekolahIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('sekolahIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    Sekolah
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ekskulIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('ekskulIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    Ekskul
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mapelIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('mapelIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    Mapel
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('tahunAjaranIndex') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('tahunAjaranIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>

                            <span class="ms-3">Tahun Ajaran</span>
                        </a>
                    </li>



                    <li>
                        <a href="{{ route('kepsekIndex') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('kepsekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            <span class="ms-3">Kepala Sekolah</span>
                        </a>
                    </li>
                @endcan


                <li>
                    <a href="{{ route('siswaIndex') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('siswaIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            <path fill-rule="evenodd"
                                d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                clip-rule="evenodd" />
                            <path
                                d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                        </svg>

                        <span class="ms-3">Siswa</span>
                    </a>
                </li>

                @can('isAdminOrKepsek', auth()->user())
                    <li>
                        <a href="{{ route('kelasIndex') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('kelasIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <span class="ms-3">Rombel</span>
                        </a>
                    </li>
                @endcan

                @can('isWaliKelas', auth()->user())
                    <li x-data="{ dropdownMasterProyek: false }">
                        <button type="button" x-on:click="dropdownMasterProyek = !dropdownMasterProyek"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                            </svg>
                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Master Proyek</span>

                            <svg :class="dropdownMasterProyek && 'hidden'" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>

                            <svg :class="dropdownMasterProyek || 'hidden'" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>
                        <ul x-show="dropdownMasterProyek" class="py-2 space-y-2" x-transition>
                            <li>
                                <a href="{{ route('dimensiIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('dimensiIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Dimensi</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('elemenIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('elemenIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Elemen</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('subelemenIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('subelemenIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Subelemen</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('capaianFaseIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('capaianFaseIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Capaian Fase</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- dropdownProyek --}}
                    <li x-data="{ dropdownProyek: false }">
                        <button type="button" x-on:click="dropdownProyek = !dropdownProyek"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>

                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Proyek</span>

                            <svg :class="dropdownProyek && 'hidden'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>

                            <svg :class="dropdownProyek || 'hidden'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>
                        <ul x-show="dropdownProyek" class="py-2 space-y-2" x-transition>
                            <li>
                                <a href="{{ route('proyekIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('proyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Daftar Proyek</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('catatanProyekEdit') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('catatanProyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Catatan Proyek</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('nilaiSubproyekIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('nilaiSubproyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Penilaian Proyek</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- dropdownProyek --}}

                    <li>
                        <a href="{{ route('raporP5Index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('raporP5Index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="ms-3">Rapor P5</span>
                        </a>
                    </li>

                    <hr class="w-full h-[1px] bg-slate-200">
                @endcan

                @can('isGuru', auth()->user())
                    {{-- inputan mapel --}}
                    <li x-data="{ dropdownInputanMapel: false }">
                        <button type="button" x-on:click="dropdownInputanMapel = !dropdownInputanMapel"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path
                                    d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>

                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Inputan
                                Mapel</span>

                            <svg :class="dropdownInputanMapel && 'hidden'" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>

                            <svg :class="dropdownInputanMapel || 'hidden'" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <ul x-show="dropdownInputanMapel" class="py-2 space-y-2" x-transition>
                            <li>
                                <a href="{{ route('lingkupMateriIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('proyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Lingkup Materi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tujuanPembelajaranIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('proyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Tujuan Pembelajaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('nilaiSumatifIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('proyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Nilai Sumatif</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('nilaiFormatifIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('proyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Nilai Formatif</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- inputan mapel --}}
                @endcan

                @can('isWaliKelas', auth()->user())
                    {{-- dropdownInputanWali --}}
                    <li x-data="{ dropdownInputanWali: false }">
                        <button type="button" x-on:click="dropdownInputanWali = !dropdownInputanWali"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.05 4.575a1.575 1.575 0 1 0-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 0 1 3.15 0v1.5m-3.15 0 .075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 0 1 3.15 0V15M6.9 7.575a1.575 1.575 0 1 0-3.15 0v8.175a6.75 6.75 0 0 0 6.75 6.75h2.018a5.25 5.25 0 0 0 3.712-1.538l1.732-1.732a5.25 5.25 0 0 0 1.538-3.712l.003-2.024a.668.668 0 0 1 .198-.471 1.575 1.575 0 1 0-2.228-2.228 3.818 3.818 0 0 0-1.12 2.687M6.9 7.575V12m6.27 4.318A4.49 4.49 0 0 1 16.35 15m.002 0h-.002" />
                            </svg>

                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Inputan Wali Kelas</span>

                            <svg :class="dropdownInputanWali && 'hidden'" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>

                            <svg :class="dropdownInputanWali || 'hidden'" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2" x-transition>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>
                        <ul x-show="dropdownInputanWali" class="py-2 space-y-2" x-transition>
                            <li>
                                <a href="{{ route('absensiIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('nilaiSubproyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Absensi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('nilaiEkskulIndex') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('nilaiSubproyekIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    <span class="ms-3">Nilai Ekskul</span>
                                </a>
                            </li>
                        </ul>
                        {{-- dropdownInputanWali --}}

                    <li>
                        <a href="{{ route('raporIntraIndex') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('raporIntraIndex') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                            </svg>

                            <span class="ms-3">Rapor Intra</span>
                        </a>
                    </li>
                @endcan

                @can('isKepsekOrWaliKelas', auth()->user())
                    <li>
                        <a href="{{ route('laporan_sumatif_kelas') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('laporan_sumatif_kelas') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                            </svg>

                            <span class="ms-3">Nilai Sumatif Perkelas</span>
                        </a>
                    </li>


                    {{-- <li>
                        <a href="{{ route('laporanRiwayatWaliKelas') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('laporanRiwayatWaliKelas') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                                <path
                                    d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                <path
                                    d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                <path
                                    d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                            </svg>

                            <span class="ms-3">Riwayat Wali Kelas</span>
                        </a>
                    </li> --}}
                @endcan

                <li>
                    <a wire:click.prevent="logout"
                        class="flex items-center p-2 text-gray-900 rounded-lg cursor-pointer dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="ms-3">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>
</div>
