<div>
    @section('table-responsive')
        <link rel="stylesheet" href="{{ asset('resources/css/responsive-table.css') }}">
    @endsection

    <x-slot:title>
        Laporan Nilai Sumatif
    </x-slot:title> {{-- blade-formatter-disable --}}
    @if (session('success'))
        <div x-init="$dispatch('showNotif', { title: 'Berhasil', description: '{{ session('success') }}', icon: 'success' })"></div>
    @endif
    @if (session('gagal'))
        <div x-init="$dispatch('showNotif', { title: 'Gagal', description: '{{ session('gagal') }}', icon: 'error' })"></div>
    @endif
    {{-- blade-formatter-enable --}}

    <h1 class="mb-3 text-2xl font-bold text-slate-700 dark:text-white">Laporan Nilai Sumatif</h1>

    <livewire:laporan-sumatif-perkelas.table />
</div>
