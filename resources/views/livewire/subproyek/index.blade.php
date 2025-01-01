<div>
    <x-slot:title>
        Subproyek
    </x-slot:title>
    <x-button href="{{ route('proyekIndex') }}" wire:navigate class="mb-1" icon="arrow-left" info label="Kembali" />

    {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Daftar Subproyek</h1>

    <x-proyek.kelas-info-table :data="$kelasInfo" />
    {{-- <div class="relative overflow-x-auto w-[55%] mb-4">
        <table
            class="w-full text-sm text-left text-gray-500 border border-gray-400 shadow-md rtl:text-right dark:text-gray-400 sm:rounded-lg">
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Judul Proyek
                </th>
                <td class="px-6 py-1">
                    {{ Str::limit($judul, 70, '...') }}
                </td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Kelas
                </th>
                <td class="px-6 py-1">
                    {{ $kelas }}
                </td>
            </tr>
            @can('superAdminOrKepsek')
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Wali Kelas
                    </th>
                    <td class="px-6 py-1">
                        {{ $waliKelas['nama_wali'] }}
                    </td>
                </tr>
            @endcan
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Fase
                </th>
                <td class="px-6 py-1">
                    {{ $fase }}
                </td>
            </tr>
            <tr>
                <th scope="row"
                    class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    Tahun Ajaran
                </th>
                <td class="px-6 py-1">
                    {{ $tahunAjaran }}
                </td>
            </tr>
        </table>
    </div> --}}

    <livewire:subproyek.form :proyekId="$proyek->id" />
</div>
