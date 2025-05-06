<?php

namespace App\Http\Middleware;

use App\TipoUsuario;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::find(Auth::user()->id);
        
        if ($user->status == 0) {
            return redirect('/logout');
        }
        
        if ($user->tipo->id == TipoUsuario::NIVEL_OPERADOR) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
