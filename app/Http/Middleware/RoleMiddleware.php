<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->role) {
            return redirect()->back()->with('error', 'Role tidak ditemukan.');
        }

        // 🔥 bersihin spasi
        $roles = array_map('trim', $roles);

        if (!in_array($user->role->name, $roles)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
