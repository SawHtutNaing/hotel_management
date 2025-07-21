<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        return $next($request);
    }
}
