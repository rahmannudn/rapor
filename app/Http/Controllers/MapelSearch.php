<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MapelSearch extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Collection
    {
        return Mapel::query()
            ->select('id', 'nama_mapel')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('nama_mapel', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
            )
            ->orderBy('nama_mapel')
            ->get();
    }
}
