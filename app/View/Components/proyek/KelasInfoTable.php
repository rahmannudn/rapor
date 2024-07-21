<?php

namespace App\View\Components\proyek;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KelasInfoTable extends Component
{
    public $data;

    /**
     * Create a new component instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.proyek.kelas-info-table', ['data' => $this->data]);
    }
}
