<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['admin', 'manager'])) {
            return redirect('/')->with('error', 'У вас немає доступу.');
        }

        return $next($request);
    }
}
