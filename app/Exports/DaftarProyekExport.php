<?php

namespace App\Exports;

use App\Models\Proyek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;


class DaftarProyekExport implements FromArray
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $daftarProyek;

    public function __construct(array $data)
    {
        $this->daftarProyek = $data;
    }

    public function array(): array
    {
        return $this->daftarProyek;
    }
}
