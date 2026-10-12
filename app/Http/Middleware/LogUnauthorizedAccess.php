<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class LogUnauthorizedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AuthorizationException $e) {

            logger()->warning(
                'Tentativa de acesso bloqueada',
                [
                    'user' => auth()->id(),
                    'ip' => $request->ip(),
                    'url' => $request->url()
                ]
            );
            throw $e;
        }
    }
}
