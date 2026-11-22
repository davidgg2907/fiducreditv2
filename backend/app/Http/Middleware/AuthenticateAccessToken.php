<?php

namespace App\Http\Middleware;

use App\Repositories\AuthTokenRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAccessToken
{
    public function __construct(private AuthTokenRepository $tokens) {}

    public function handle(Request $request, Closure $next): mixed
    {
        abort_if(config('auth_tokens.cookie_secure') && !$request->isSecure(), 403, 'HTTPS es obligatorio.');

        $user = $this->tokens->authenticate($request->bearerToken());
        if (!$user) {
            return response()->json(['isSuccess' => false, 'message' => 'La sesión no es válida o ya expiró.'], 401);
        }

        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
