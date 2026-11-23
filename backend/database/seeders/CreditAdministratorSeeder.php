<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\Totp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\AuthTokenRepository;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

final class CreditAdministratorSeeder extends Seeder
{
    private const EMAIL = 'administrador@nahuicredit.com';
    private const ROLE = 'Superadministrador NAHUICREDIT';
    // Contraseña solicitada exclusivamente para desarrollo local; nunca en producción.
    private const LOCAL_PASSWORD = 'admin23';

    public function run(): void
    {
        DB::transaction(function (): void {
            // El catálogo se ejecuta antes que este seeder: los permisos incluyen los cinco subsistemas.
            $permissions = DB::table('module_actions')->orderBy('permission')->pluck('permission')->all();
            if ($permissions === []) {
                throw new RuntimeException('Primero ejecuta AccessCatalogSeeder y CreditSystemMenusSeeder.');
            }

            $role = Role::firstOrCreate(['name' => self::ROLE], ['permissions' => $permissions]);
            $role->permissions = $permissions;
            $role->save();

            $admin = User::where('email', self::EMAIL)->lockForUpdate()->first();
            if ($admin && !$admin->is_superadmin) {
                throw new RuntimeException('La cuenta reservada de NAHUICREDIT existe sin privilegios. Requiere revisión administrativa.');
            }

            if (!$admin) {
                // Nunca publicar credenciales privilegiadas ni crear cuentas implícitas en producción.
                if (!app()->environment('local')) {
                    $this->command?->warn('Provisiona de forma segura administrador@nahuicredit.com antes de iniciar producción.');
                    return;
                }
                if (User::where('is_superadmin', true)->exists()) {
                    throw new RuntimeException('Existe un superadministrador distinto. Revisa las cuentas antes del bootstrap.');
                }

                $password = self::LOCAL_PASSWORD;
                $secret = app(Totp::class)->generateSecret();
                $admin = User::unguarded(fn () => User::create([
                    'name' => 'Administrador NAHUICREDIT',
                    'email' => self::EMAIL,
                    'password' => $password,
                    'is_superadmin' => true,
                    'is_active' => true,
                    'role_id' => $role->id,
                    'mfa_secret' => $secret,
                ]));
                $this->command?->warn('SOLO DESARROLLO LOCAL: contraseña temporal deliberadamente débil. Cambiar antes de producción.');
                $this->command?->line('Usuario: '.self::EMAIL);
                $this->command?->line('Contraseña temporal: '.$password);
                $this->command?->line('Clave TOTP para uso futuro: '.$secret);
            } else {
                // En local, migrate --seed garantiza credenciales de prueba reproducibles.
                // No modifica contraseña ni sesiones en ambientes distintos de local.
                if (app()->environment('local') && !Hash::check(self::LOCAL_PASSWORD, $admin->password)) {
                    $admin->password = self::LOCAL_PASSWORD;
                    app(AuthTokenRepository::class)->revokeForUser($admin->id);
                    $this->command?->warn('Contraseña local restablecida a admin23. Nunca usar en producción.');
                }
                $admin->role_id = $role->id;
                $admin->is_superadmin = true;
                $admin->is_active = true;
                $admin->save();
                $this->command?->line('Superadministrador sincronizado: '.self::EMAIL);
            }
        }, 3);
    }
}
