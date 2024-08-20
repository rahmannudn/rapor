<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckProyekPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $proyek = Proyek::find($request->proyek->id);
        if (!Gate::allows('viewAny', $proyek)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
