<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Periksa apakah peran user ada dalam daftar peran yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Jika tidak, redirect atau tampilkan error
            abort(403, 'Unauthorized action.'); // Tampilkan error 403 (Forbidden)
        }

        return $next($request);
    }
}