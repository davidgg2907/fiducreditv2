<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Services\Totp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ArquetipoTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'Password123456';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeader('X-Auth-Request', '1');
    }

    public function test_rutas_y_proteccion_de_origen(): void
    {
        $this->getJson('/api/login/branding')->assertOk();
        $this->getJson('/api/login/public-key')->assertNotFound();
        $this->getJson('/api/perfil')->assertUnauthorized();
        $this->postJson('/api/perfil/contrasena')->assertUnauthorized();
        $this->getJson('/api/cat-areas')->assertNotFound();

        $this->flushHeaders()->postJson('/api/login/refresh')->assertForbidden();
        $this->withHeaders(['X-Auth-Request' => '1', 'Origin' => 'https://untrusted.example'])
            ->postJson('/api/login/refresh')->assertForbidden();
    }

    public function test_https_y_limite_de_login_por_cuenta(): void
    {
        config(['auth_tokens.cookie_secure' => true]);
        $user = $this->ordinaryUser();
        $credentials = ['email' => $user->email, 'password' => self::PASSWORD];
        $this->postJson('/api/login', $credentials)->assertForbidden();

        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->postJson('https://localhost/api/login', ['email' => strtoupper($user->email), 'password' => 'Invalid-password'])
                ->assertUnauthorized();
        }
        $this->postJson('https://localhost/api/login', $credentials)->assertTooManyRequests();
    }

    public function test_sesion_unica_renueva_despues_del_access_y_rechaza_la_rotacion_anterior(): void
    {
        $user = $this->ordinaryUser();
        $credentials = ['email' => $user->email, 'password' => self::PASSWORD, 'remember' => true];
        $login = $this->postJson('/api/login', $credentials)->assertOk();
        $access = $login->json('data.tokens.accessToken');
        $refresh = $login->getCookie(config('auth_tokens.refresh_cookie_name'), false);
        $this->assertTrue($refresh->isHttpOnly());
        $this->assertSame('lax', $refresh->getSameSite());
        $login->assertJsonMissingPath('data.tokens.refreshToken');

        $this->assertDatabaseHas('oauth_access_tokens', ['id' => hash('sha256', $access)]);
        $this->assertDatabaseHas('oauth_refresh_tokens', ['id' => hash('sha256', $refresh->getValue())]);
        $this->assertDatabaseMissing('oauth_access_tokens', ['id' => $access]);
        $this->assertDatabaseMissing('oauth_refresh_tokens', ['id' => $refresh->getValue()]);

        $this->travel(16)->minutes();
        $this->postJson('/api/login', $credentials)->assertConflict();
        $this->withToken($access)->getJson('/api/perfil')->assertUnauthorized();

        $this->postJson('/api/login/refresh', ['refreshToken' => $refresh->getValue()])->assertUnauthorized();
        $renewed = $this->withCredentials()->withUnencryptedCookie($refresh->getName(), $refresh->getValue())
            ->postJson('/api/login/refresh')->assertOk();
        $this->postJson('/api/login/refresh')->assertUnauthorized();

        $newAccess = $renewed->json('data.tokens.accessToken');
        $this->withToken($newAccess)->getJson('/api/perfil')->assertOk()
            ->assertJsonPath('data.user.userId', $user->id);
        $newRefresh = $renewed->getCookie($refresh->getName(), false);
        $this->assertSame($refresh->getExpiresTime(), $newRefresh->getExpiresTime());

        $this->travel(16)->minutes();
        $this->withCredentials()->withUnencryptedCookie($newRefresh->getName(), $newRefresh->getValue())
            ->postJson('/api/logout')->assertOk();
        $this->postJson('/api/login/refresh')->assertUnauthorized();
        $this->assertDatabaseCount('auth_sessions', 0);
    }

    public function test_recarga_con_cookie_http_only_recupera_sesion_y_rota_token(): void
    {
        $user = $this->ordinaryUser();
        $login = $this->postJson('/api/login', [
            'email' => $user->email, 'password' => self::PASSWORD,
            'remember' => false,
        ])->assertOk();

        $cookie = $login->getCookie(config('auth_tokens.refresh_cookie_name'), false);
        $this->assertNotNull($cookie);
        $this->assertSame('/api', $cookie->getPath());
        $this->assertTrue($cookie->isHttpOnly());
        $this->assertSame('lax', $cookie->getSameSite());

        // La recarga de una SPA pierde el access token en memoria. El navegador conserva
        // la cookie de sesión y hace POST /api/login/refresh antes de renderizar.
        $oldAccess = $login->json('data.tokens.accessToken');
        $restore = $this->withHeaders(['X-Auth-Request' => '1', 'X-Frontend-App' => 'configuracion-sistema'])
            ->withCredentials()->withUnencryptedCookie($cookie->getName(), $cookie->getValue())
            ->postJson('/api/login/refresh')->assertOk();
        $newAccess = $restore->json('data.tokens.accessToken');
        $this->assertNotSame($oldAccess, $newAccess);
        $this->withToken($newAccess)->getJson('/api/me')->assertOk()
            ->assertJsonPath('data.user.userId', $user->id);

        // También debe funcionar después de otra recarga; en cada refresh la cookie rota.
        $rotated = $restore->getCookie($cookie->getName(), false);
        $this->assertNotSame($cookie->getValue(), $rotated->getValue());
        $again = $this->withHeaders(['X-Auth-Request' => '1', 'X-Frontend-App' => 'configuracion-sistema'])
            ->withCredentials()->withUnencryptedCookie($rotated->getName(), $rotated->getValue())
            ->postJson('/api/login/refresh')->assertOk();
        $this->withToken($again->json('data.tokens.accessToken'))->getJson('/api/me')->assertOk();
    }

    public function test_la_inactividad_expira_una_sesion_recordada(): void
    {
        $user = $this->ordinaryUser();
        $login = $this->postJson('/api/login', [
            'email' => $user->email, 'password' => self::PASSWORD, 'remember' => true,
        ])->assertOk();
        $refresh = $login->getCookie(config('auth_tokens.refresh_cookie_name'), false);
        $this->travel(91)->minutes();
        $this->withCredentials()->withUnencryptedCookie($refresh->getName(), $refresh->getValue())
            ->postJson('/api/login/refresh')->assertUnauthorized();
        $this->assertDatabaseCount('auth_sessions', 0);
    }

    public function test_cambio_y_restablecimiento_revocan_las_sesiones(): void
    {
        $user = $this->ordinaryUser();
        $first = $this->postJson('/api/login', ['email' => $user->email, 'password' => self::PASSWORD])->assertOk();
        $this->assertSame(0, $first->getCookie(config('auth_tokens.refresh_cookie_name'), false)->getExpiresTime());
        $this->withToken($first->json('data.tokens.accessToken'))->postJson('/api/perfil/contrasena', [
            'contrasena_actual' => self::PASSWORD,
            'contrasena' => 'New-password-123',
            'contrasena_confirmation' => 'New-password-123',
        ])->assertOk();
        $this->getJson('/api/perfil')->assertUnauthorized();

        Notification::fake();
        $this->postJson('/api/password/forgot', ['email' => $user->email])->assertOk();
        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\ResetPassword::class);
        $token = Password::createToken($user);
        $next = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'New-password-123'])
            ->assertOk();
        $reset = [
            'email' => $user->email, 'token' => $token,
            'password' => 'Reset-password-456', 'password_confirmation' => 'Reset-password-456',
        ];
        $this->postJson('/api/password/reset', $reset)->assertOk();
        $this->postJson('/api/password/reset', $reset)->assertUnprocessable();
        $this->withToken($next->json('data.tokens.accessToken'))->getJson('/api/perfil')->assertUnauthorized();
    }

    public function test_superadmin_unico_con_mfa_y_acceso_global(): void
    {
        $ordinary = $this->ordinaryUser();
        $this->artisan('access:bootstrap')
            ->expectsQuestion('Nombre del superadministrador', 'Root')
            ->expectsQuestion('Correo electrónico', 'root@example.test')
            ->expectsQuestion('Contraseña (mínimo 12 caracteres, máximo 72 bytes)', self::PASSWORD)
            ->expectsQuestion('Repita la contraseña', self::PASSWORD)
            ->assertSuccessful();
        $this->artisan('access:bootstrap')->assertFailed();
        $root = User::where('email', 'root@example.test')->firstOrFail();
        $this->assertTrue($root->is_superadmin);
        $this->assertTrue(Gate::forUser($root)->allows('use-permission', 'new-module.view'));
        $this->assertFalse(Gate::forUser($ordinary)->allows('use-permission', 'new-module.view'));
        $this->assertTrue(Gate::forUser($root)->allows('view', $ordinary));
        $this->assertFalse(Gate::forUser($ordinary)->allows('view', $root));
        $role = Role::create(['name' => 'Reader', 'permissions' => ['new-module.view']]);
        $ordinary->role()->associate($role)->save();
        $this->assertTrue(Gate::forUser($ordinary)->allows('use-permission', 'new-module.view'));
        $this->assertFalse(Gate::forUser($ordinary)->allows('use-permission', 'new-module.edit'));

        $root->mfa_secret = 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ';
        $root->save();
        $this->travelTo(now()->setTimestamp(59));
        $credentials = ['email' => $root->email, 'password' => self::PASSWORD];
        $this->postJson('/api/login', $credentials)->assertUnauthorized()->assertJsonPath('mfaRequired', true);
        $this->assertSame(1, app(Totp::class)->matchingStep($root->mfa_secret, '287082', null));
        $login = $this->postJson('/api/login', $credentials + ['mfa_code' => '287082'])
            ->assertOk()->assertJsonPath('data.user.isAdmin', true);
        $this->withToken($login->json('data.tokens.accessToken'))->postJson('/api/logout')->assertOk();
        $this->postJson('/api/login', $credentials + ['mfa_code' => '287082'])->assertUnauthorized();
    }

    private function ordinaryUser(): User
    {
        return User::create(['name' => 'Cuenta normal', 'email' => 'user@example.test', 'password' => self::PASSWORD]);
    }
}
