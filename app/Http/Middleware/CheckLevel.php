<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
 
class CheckLevel
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirige al login si no está autenticado
        }
 
        // Obtiene el nivel del usuario autenticado
        $userLevel = Auth::user()->level;
 
        // Si el nivel del usuario no está en los permitidos, redirige a "access_denied"
        if (!in_array($userLevel, $levels)) {
            return response()->view('errors.access_denied', [], 403);
        }
 
        return $next($request);
    }
}