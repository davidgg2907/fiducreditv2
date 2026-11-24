<?php

namespace App\Http\Controllers;

use App\Exceptions\ActiveSessionExistsException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordRules;
use App\Models\User;
use App\Repositories\AuthTokenRepository;
use App\Services\SessionMenu;
use App\Services\Totp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{
    public function __construct(private AuthTokenRepository $tokens, private SessionMenu $menu) {}

    public function login(LoginRequest $request, Totp $totp): JsonResponse
    {
        try {
            $pair = $this->tokens->attemptLogin(
                $request->string('email')->trim()->lower()->value(),
                $request->validated('password'),
                $request->boolean('remember'),
                $request->validated('mfa_code'),
                $totp,
                $request->boolean('replace_session'),
            );
        } catch (ActiveSessionExistsException $exception) {
            return $this->failure($exception->getMessage(), 409);
        }

        if (!$pair) {
            return $this->failure('Las credenciales proporcionadas no son válidas.', 401);
        }
        if (isset($pair['mfa_required'])) {
            return response()->json([
                'isSuccess' => false,
                'mfaRequired' => true,
                'message' => 'Ingresa un código vigente de tu aplicación de autenticación.',
            ], 401);
        }

        return $this->sessionResponse($pair);
    }

    public function refresh(Request $request): JsonResponse
    {
        $pair = $this->tokens->refresh($request->cookie(config('auth_tokens.refresh_cookie_name')));

        // A concurrent tab may have already set a new cookie. Leave it intact on rejection.
        return $pair
            ? $this->sessionResponse($pair)
            : $this->failure('La sesión expiró o no es válida.', 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->tokens->logout(
            $request->bearerToken(),
            $request->cookie(config('auth_tokens.refresh_cookie_name')),
        );

        return response()->json(['isSuccess' => true])->withCookie($this->expiredCookie());
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['isSuccess' => true, 'data' => ['user' => $this->userData($request->user())]])
            ->header('Cache-Control', 'no-store');
    }

    public function profile(Request $request): JsonResponse
    {
        Gate::authorize('view', $request->user());

        return response()->json(['isSuccess' => true, 'data' => $this->profileData($request->user())]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        Gate::authorize('update', $user);
        $request->mergeIfMissing(['correo' => $user->email]);
        $request->merge(['correo' => is_string($request->input('correo'))
            ? strtolower(trim($request->input('correo')))
            : $request->input('correo')]);
        $data = $request->validate([
            'nombre' => ['sometimes', 'required', 'string', 'max:250'],
            'correo' => ['required', 'email', 'max:250', Rule::unique('users', 'email')->ignore($user->id)],
            'contrasena_actual' => ['nullable', 'string', PasswordRules::maximumBytes()],
        ]);

        $updated = DB::transaction(function () use ($user, $data) {
            $current = User::lockForUpdate()->findOrFail($user->id);
            if ($data['correo'] !== $current->email) {
                $this->validateCurrentPassword($current, $data['contrasena_actual'] ?? '');
                Password::deleteToken($current);
                $current->email = $data['correo'];
                $current->email_verified_at = null;
            }
            $current->name = $data['nombre'] ?? $current->name;
            $current->save();

            return $current;
        }, 3);

        return response()->json([
            'isSuccess' => true,
            'message' => 'Perfil actualizado correctamente.',
            'data' => $this->profileData($updated),
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'contrasena_actual' => ['required', 'string', PasswordRules::maximumBytes()],
            'contrasena' => ['required', 'string', 'min:12', PasswordRules::maximumBytes(), 'confirmed'],
        ]);
        $id = $request->user()->id;

        DB::transaction(function () use ($id, $data) {
            $user = User::lockForUpdate()->findOrFail($id);
            $this->validateCurrentPassword($user, $data['contrasena_actual']);
            $this->replacePassword($user, $data['contrasena']);
        }, 3);

        return response()->json([
            'isSuccess' => true,
            'message' => 'Contraseña actualizada. Inicia sesión nuevamente.',
        ])->withCookie($this->expiredCookie());
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $email = $this->validateRecoveryEmail($request);
        abort_if(
            app()->environment('production') && in_array(config('mail.default'), ['log', 'array'], true),
            503,
            'La recuperación requiere un servicio de correo configurado.',
        );
        Password::sendResetLink(['email' => $email]);

        return response()->json([
            'isSuccess' => true,
            'message' => 'Si el correo está registrado, recibirás un enlace de recuperación.',
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $email = $this->validateRecoveryEmail($request);
        $data = $request->validate([
            'token' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:12', PasswordRules::maximumBytes(), 'confirmed'],
        ]);

        $reset = DB::transaction(function () use ($email, $data) {
            $user = User::where('email', $email)->lockForUpdate()->first();
            if (!$user || !Password::tokenExists($user, $data['token'])) {
                return false;
            }
            $this->replacePassword($user, $data['password']);

            return true;
        }, 3);

        if (!$reset) {
            throw ValidationException::withMessages(['email' => 'El enlace de recuperación es inválido o expiró.']);
        }

        return response()->json([
            'isSuccess' => true,
            'message' => 'Contraseña restablecida. Ya puedes iniciar sesión.',
        ]);
    }

    private function validateRecoveryEmail(Request $request): string
    {
        return strtolower(trim($request->validate(['email' => ['required', 'email', 'max:255']])['email']));
    }

    private function validateCurrentPassword(User $user, string $password): void
    {
        if (!Hash::check($password, $user->password)) {
            throw ValidationException::withMessages(['contrasena_actual' => 'La contraseña actual no es correcta.']);
        }
    }

    private function replacePassword(User $user, string $password): void
    {
        $user->password = $password;
        $user->setRememberToken(null);
        $user->save();
        Password::deleteToken($user);
        $this->tokens->revokeForUser($user->id);
    }

    private function failure(string $message, int $status): JsonResponse
    {
        return response()->json(['isSuccess' => false, 'message' => $message], $status);
    }

    private function expiredCookie(): Cookie
    {
        return $this->tokens->refreshCookie('', 1);
    }

    private function sessionResponse(array $pair): JsonResponse
    {
        return response()->json([
            'isSuccess' => true,
            'data' => [
                'user' => $this->userData($pair['user']),
                'tokens' => [
                    'accessToken' => $pair['access'],
                    'accessTokenExpiresAt' => $pair['access_expires_at']->toIso8601String(),
                ],
            ],
        ])->header('Cache-Control', 'no-store')
            ->withCookie($this->tokens->refreshCookie($pair['refresh'], $pair['cookie_expires_at']));
    }

    private function userData(User $user): array
    {
        $role = $user->role;
        $permissions = $user->permissions();

        return [
            'userId' => $user->id,
            'nombre' => $user->name,
            'email' => $user->email,
            'isAdmin' => (bool) $user->is_superadmin,
            'role' => $role?->only(['id', 'name']),
            'permissions' => $permissions,
            'menu' => $this->menu->forPermissions($permissions, (bool) $user->is_superadmin, $this->requestedFrontend()),
        ];
    }

    private function requestedFrontend(): ?string
    {
        $value = request()->header('X-Frontend-App');
        return in_array($value, [
            'originacion', 'administracion', 'pld-operacion',
            'pld-configuracion', 'configuracion-sistema',
        ], true) ? $value : null;
    }

    private function profileData(User $user): array
    {
        return ['user' => $this->userData($user), 'personal' => ['nombre' => $user->name, 'correo' => $user->email]];
    }
}
