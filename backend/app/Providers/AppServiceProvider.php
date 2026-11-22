<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::before(fn (User $user) => $user->is_superadmin ? true : null);
        Gate::define('manage-access', fn (User $user) => $user->is_superadmin);
        Gate::define('use-permission', fn (User $user, string $permission) => in_array(
            $permission,
            $user->permissions(),
            true,
        ));

        RateLimiter::for('auth-login', fn (Request $request) => [
            Limit::perMinute(15)->by('ip:'.$request->ip()),
            Limit::perMinute(6)->by('account:'.$this->accountKey($request)),
        ]);

        RateLimiter::for('auth-recovery', fn (Request $request) => [
            Limit::perMinute(10)->by('ip:'.$request->ip()),
            Limit::perMinute(4)->by('account:'.$this->accountKey($request)),
        ]);

        RateLimiter::for('auth-session', fn (Request $request) => Limit::perMinute(30)->by($request->ip()));
        RateLimiter::for('auth-sensitive', fn (Request $request) => [
            Limit::perMinute(15)->by('ip:'.$request->ip()),
            Limit::perMinute(6)->by('account:'.$request->user()->id),
        ]);

        ResetPassword::createUrlUsing(function (User $user, string $token): string {
            return rtrim(config('auth_tokens.frontend_url'), '/').'/recuperar-acceso?'.http_build_query([
                'token' => $token,
                'email' => $user->email,
            ]);
        });
    }

    private function accountKey(Request $request): string
    {
        $email = $request->input('email');

        return hash('sha256', is_string($email) ? strtolower(trim($email)) : '');
    }
}
