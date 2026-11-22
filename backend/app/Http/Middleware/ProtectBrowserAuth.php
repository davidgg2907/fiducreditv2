<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProtectBrowserAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        abort_if(config('auth_tokens.cookie_secure') && !$request->isSecure(), 403, 'HTTPS es obligatorio.');
        abort_unless($request->header('X-Auth-Request') === '1', 403, 'Solicitud de autenticación inválida.');

        $origin = $request->header('Origin');
        $allowed = [$request->getSchemeAndHttpHost(), ...config('cors.allowed_origins')];
        abort_if($origin !== null && !in_array($origin, $allowed, true), 403, 'Origen no autorizado.');

        return $next($request);
    }
}
