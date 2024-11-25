<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Filament\Notifications\Notification;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && !auth()->user()->is_active) {
            auth()->logout();

            // Para Filament, usamos sus notificaciones nativas
            Notification::make()
                ->title('Cuenta desactivada')
                ->body('Tu cuenta ha sido desactivada. Por favor, contacta al administrador.')
                ->danger()
                ->persistent()
                ->send();

            return redirect()->route('filament.admin.auth.login');
        }


        return $next($request);
    }
}
