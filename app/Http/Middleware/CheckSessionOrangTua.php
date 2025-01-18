<?php

namespace App\Http\Middleware;

use App\Models\WaliKelas;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckSessionOrangTua
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user login (admin, guru, dll.), izinkan
        if (Auth::check() && in_array(Auth::user()->role, ['kepsek', 'guru'])) {
            if (Auth::user()->role == 'guru') {
                $tahunAjaran = Cache::get('tahunAjaranAktif');
                $waliKelas = WaliKelas::where('user_id', '=', Auth::id())->where('tahun_ajaran_id', '=', $tahunAjaran)
                    ->get();
                if (empty($waliKelas)) return redirect('/unauthorized')->with('error', 'Anda tidak memiliki akses ke data ini.');
            }
            return $next($request);
        }

        // jika sesi orang tua habis maka dialihkan ke halaman home
        if (!Session::has('authenticated_parent')) {
            return redirect()->route('homePage')->with('errorMessage', 'Sesi telah habis atau tidak valid.');
        }

        // Cek apakah user adalah orang tua
        if (session()->has('authenticated_parent')) {
            $expiryTime = session('parent_session_expiry');

            $requestedStudentObject = $request->route('siswa');
            if ($requestedStudentObject['id'] != session('authenticated_parent'))
                return redirect('/unauthorized')->with('error', 'Anda tidak memiliki akses ke data ini.');

            // Hapus session jika waktu kedaluwarsa tercapai
            if (now()->greaterThan($expiryTime)) {
                session()->forget(['authenticated_parent', 'parent_session_expiry']);
                return redirect('/#form-section')->with('errorMessage', 'Sesi Anda telah kedaluwarsa.');
            }
            return $next($request);
        }

        // Redirect jika tidak memenuhi syarat
        return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}
