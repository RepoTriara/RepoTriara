<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;

class HandleNotFound
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (NotFoundHttpException $e) {
            if (Auth::check()) {
                return redirect()->back()->with('error', 'Página no encontrada. Volviendo atrás.');
            }
            return redirect()->route('login')->with('error', 'Página no encontrada. Inicia sesión.');
        }
    }
}

