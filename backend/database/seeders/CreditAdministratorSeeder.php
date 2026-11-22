<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Totp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

final class CreditAdministratorSeeder extends Seeder
{
    private const EMAIL = 'administrador@nahuicredit.com';

    public function run(): void
    {
        // Auto-bootstrap is strictly for local development. Never create a
        // privileged account implicitly in production, staging or tests.
        if (! app()->environment('local')) {
            return;
        }

        $credentials = DB::transaction(function (): ?array {
            $root = User::where('is_superadmin', true)->lockForUpdate()->first();
            $existing = User::where('email', self::EMAIL)->lockForUpdate()->first();

            if ($root) {
                // Existing bootstrap credentials must never be reset by seeding.
                return null;
            }
            if ($existing) {
                throw new RuntimeException(
                    'El correo del administrador ya pertenece a un usuario sin privilegios. '
                    .'Revisa esta cuenta manualmente antes de crear el superadministrador.'
                );
            }

            $password = Str::random(24);
            $secret = app(Totp::class)->generateSecret();

            User::unguarded(fn () => User::create([
                'name' => 'Administrador FiduCredit',
                'email' => self::EMAIL,
                'password' => $password,
                'is_superadmin' => true,
                'is_active' => true,
                'mfa_secret' => $secret,
                'role_id' => null,
            ]));

            return ['password' => $password, 'mfa_secret' => $secret];
        }, 3);

        if ($credentials === null) {
            $this->command?->line('Administrador existente: se conservan sus credenciales.');
            return;
        }

        // Shown only at initial local bootstrap; never persisted as plaintext
        // in seeders, .env, the database or committed files.
        $this->command?->warn('CREDENCIALES INICIALES - SOLO ENTORNO LOCAL. GUARDAR EN LUGAR SEGURO.');
        $this->command?->line('Usuario: '.self::EMAIL);
        $this->command?->line('Contraseña temporal: '.$credentials['password']);
        $this->command?->line('Clave TOTP para la aplicación autenticadora: '.$credentials['mfa_secret']);
        $this->command?->warn('Estas claves no se volverán a mostrar al ejecutar el seeder.');
    }
}
