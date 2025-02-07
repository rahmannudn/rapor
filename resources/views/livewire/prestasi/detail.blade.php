<div>
    <div class="w-full p-4 space-y-4 bg-white border-b border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700">
        <x-slot:title>
            Detail Prestasi
        </x-slot:title> <x-button href="{{ route('prestasiIndex') }}" wire:navigate class="mb-1" icon="arrow-left"
            info label="Kembali" />
        <h1 class="mb-1 text-2xl font-bold text-slate-700">Detail Prestasi</h1>
        <div class="mb-2 space-y-4">

            <x-input label="Siswa" wire:model='namaSiswa' disabled />
            <x-input label="Kelas Saat Ini" wire:model='namaKelas' disabled />
            <x-input label="Nama Prestasi" wire:model='namaPrestasi' disabled />
            <x-input label="Tanggal Prestasi" wire:model='tglPrestasi' disabled />
            <x-input label="Penyelenggara" wire:model='penyelenggara' disabled />
            <x-textarea wire:model="deskripsi" label="Deskripsi" disabled />
            @if ($bukti)
                <p>Bukti</p>
                <a href="{{ url('storage/' . $bukti) }}" target="_blank">
                    <x-avatar size="w-24 h-24" squared src="{{ url('storage/' . $bukti) }}" />
                </a>
            @endif
            <x-input label="Nilai Prestasi" wire:model='nilaiPrestasi' disabled />
        </div>
    </div>
</div>
