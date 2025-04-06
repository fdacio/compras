<?php

namespace App\Http\Middleware;

use Closure;
use App\Rota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class CheckPermissao
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
        $routesAdmin = [
            'user.index',
            'user.create',
            'user.store',
            'user.edit',
            'user.update',
            'user.destroy',
            'tipos-usuarios.index',
            'tipos-usuarios.create',
            'tipos-usuarios.store',
            'tipos-usuarios.edit',
            'tipos-usuarios.update',
            'tipos-usuarios.destroy',
            'requisicoes-compras.autorizar',
            'autorizacoes-pagamentos.autorizar',            
        ];
        
        $routeName = $request->route()->getName();
        $nivelUsuario = Auth::user()->tipo->id;
        
        if ($nivelUsuario == 1) {
            $verificarPermissao = true;
        } elseif ($nivelUsuario == 2 && in_array($routeName, $routesAdmin)) {
            $verificarPermissao = true;
        } else {
            $verificarPermissao = false;
        }

        if ($verificarPermissao) {
            if (Gate::denies($routeName)) {
                
                return redirect()->route('home')->with('error', 'Usuário não tem autorização para esta ação.');
            }
        }

        return $next($request);
    }
}
