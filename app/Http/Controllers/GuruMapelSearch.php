<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GuruMapelSearch extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Collection
    {
        return User::query()
            ->select('id as id_user', 'name as nama_guru', 'email')
            ->where('role', '=', 'guru')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('nama_guru', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected') && $request['selected'] !== '',
                fn (Builder $query) => $query->whereIn('id_user', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->orderBy('name')
            ->get();
    }
}
