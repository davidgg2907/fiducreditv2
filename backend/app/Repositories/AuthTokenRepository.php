<?php

namespace App\Repositories;

use App\Exceptions\ActiveSessionExistsException;
use App\Models\OauthAccessToken;
use App\Models\OauthRefreshToken;
use App\Models\User;
use App\Services\Totp;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class AuthTokenRepository
{
    public function attemptLogin(string $email, string $password, bool $remember, ?string $code, Totp $totp): ?array
    {
        $candidate = User::where('email', $email)->first();

        if (!$candidate || !$candidate->is_active || !Hash::check($password, $candidate->password)) {
            return null;
        }

        return DB::transaction(function () use ($candidate, $password, $remember, $code, $totp) {
            $user = User::lockForUpdate()->find($candidate->id);
            if (!$user || !$user->is_active || $user->password !== $candidate->password || $user->email !== $candidate->email) {
                return null;
            }

            if (config('auth_tokens.require_mfa', false) && ($user->is_superadmin || $user->mfa_secret)) {
                $step = $code && $user->mfa_secret
                    ? $totp->matchingStep($user->mfa_secret, $code, $user->mfa_last_step)
                    : null;
                if ($step === null) {
                    return ['mfa_required' => true];
                }
                $user->mfa_last_step = $step;
            }

            $session = $this->session($user->id);
            if ($session && $this->isActive($session)) {
                throw new ActiveSessionExistsException('El usuario ya cuenta con una sesión activa.');
            }

            if (Hash::needsRehash($user->password)) {
                $user->password = $password;
            }
            if ($user->isDirty()) {
                $user->save();
            }

            $this->revokeForUser($user->id);
            $minutes = config($remember ? 'auth_tokens.refresh_token_ttl_remember' : 'auth_tokens.refresh_token_ttl');

            return $this->createPair($user, $remember, now()->toImmutable()->addMinutes($minutes));
        }, 3);
    }

    public function refresh(?string $credential): ?array
    {
        $userId = $this->userIdForRefresh($credential);
        if (!$userId) {
            return null;
        }

        return DB::transaction(function () use ($userId, $credential) {
            $user = User::lockForUpdate()->find($userId);
            $session = $this->session($userId);
            if (!$user || !$user->is_active || !$session || !$this->matchesRefresh($session, $credential)) {
                return null;
            }

            if (!$this->isActive($session)) {
                $this->revokeForUser($userId);
                return null;
            }

            $this->revokeForUser($userId);

            return $this->createPair($user, (bool) $session->remember, CarbonImmutable::parse($session->expires_at));
        }, 3);
    }

    public function authenticate(?string $credential): ?User
    {
        $hash = $this->tokenHash($credential);
        $userId = $hash ? OauthAccessToken::whereKey($hash)->value('user_id') : null;
        if (!$userId) {
            return null;
        }

        return DB::transaction(function () use ($userId, $hash) {
            $user = User::lockForUpdate()->find($userId);
            $session = $this->session($userId);
            if (!$user || !$user->is_active || !$session || !hash_equals($session->access_token_id, $hash)) {
                return null;
            }
            if (!$this->isActive($session)) {
                $this->revokeForUser($userId);
                return null;
            }
            $token = OauthAccessToken::find($hash);
            if (!$token || $token->revoked || !$token->expires_at?->isFuture()) {
                return null;
            }

            DB::table('auth_sessions')->where('user_id', $userId)->update(['last_activity_at' => now()]);

            return $user;
        }, 3);
    }

    public function logout(?string $access, ?string $refresh): void
    {
        $hash = $this->tokenHash($access);
        $userId = ($hash ? OauthAccessToken::whereKey($hash)->value('user_id') : null)
            ?? $this->userIdForRefresh($refresh);
        if (!$userId) {
            return;
        }

        DB::transaction(function () use ($userId, $hash, $refresh) {
            User::lockForUpdate()->find($userId);
            $session = $this->session($userId);
            $accessMatches = $session && $hash && hash_equals($session->access_token_id, $hash);
            if ($session && ($accessMatches || $this->matchesRefresh($session, $refresh))) {
                $this->revokeForUser($userId);
            }
        }, 3);
    }

    // The caller owns the lock on the user row.
    public function revokeForUser(int $userId): void
    {
        $session = $this->session($userId);
        if ($session) {
            DB::table('auth_sessions')->where('user_id', $userId)->delete();
            OauthRefreshToken::where('access_token_id', $session->access_token_id)->delete();
            OauthAccessToken::whereKey($session->access_token_id)->delete();
        }
    }

    public function refreshCookie(string $token, int $expiresAt): Cookie
    {
        return Cookie::create(
            config('auth_tokens.refresh_cookie_name'),
            $token,
            $expiresAt,
            '/api',
            null,
            (bool) config('auth_tokens.cookie_secure'),
            true,
            false,
            config('auth_tokens.cookie_same_site'),
        );
    }

    private function createPair(User $user, bool $remember, CarbonImmutable $expiresAt): array
    {
        $access = Str::random(80);
        $refresh = Str::random(80);
        $accessHash = hash('sha256', $access);
        $accessExpiry = now()->toImmutable()->addMinutes(config('auth_tokens.access_token_ttl'))->min($expiresAt);

        OauthAccessToken::create([
            'id' => $accessHash,
            'user_id' => $user->id,
            'name' => config('app.name').' SPA',
            'expires_at' => $accessExpiry,
        ]);
        OauthRefreshToken::create([
            'id' => hash('sha256', $refresh),
            'access_token_id' => $accessHash,
            'expires_at' => $expiresAt,
        ]);
        DB::table('auth_sessions')->insert([
            'user_id' => $user->id,
            'access_token_id' => $accessHash,
            'remember' => $remember,
            'expires_at' => $expiresAt,
            'last_activity_at' => now(),
        ]);

        return [
            'user' => $user,
            'access' => $access,
            'access_expires_at' => $accessExpiry,
            'refresh' => $refresh,
            'cookie_expires_at' => $remember ? $expiresAt->timestamp : 0,
        ];
    }

    private function session(int $userId): ?object
    {
        return DB::table('auth_sessions')->where('user_id', $userId)->first();
    }

    private function isActive(object $session): bool
    {
        return CarbonImmutable::parse($session->expires_at)->isFuture()
            && CarbonImmutable::parse($session->last_activity_at)
                ->addMinutes(config('auth_tokens.idle_timeout_minutes'))->isFuture();
    }

    private function userIdForRefresh(?string $credential): ?int
    {
        $hash = $this->tokenHash($credential);
        $refresh = $hash ? OauthRefreshToken::find($hash) : null;
        return $refresh ? OauthAccessToken::whereKey($refresh->access_token_id)->value('user_id') : null;
    }

    private function matchesRefresh(object $session, ?string $credential): bool
    {
        $hash = $this->tokenHash($credential);
        $refresh = $hash ? OauthRefreshToken::find($hash) : null;

        return $refresh && !$refresh->revoked && $refresh->expires_at?->isFuture()
            && hash_equals($session->access_token_id, $refresh->access_token_id);
    }

    private function tokenHash(?string $credential): ?string
    {
        return $credential && preg_match('/\A[A-Za-z0-9]{80}\z/', $credential)
            ? hash('sha256', $credential)
            : null;
    }
}
