<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreditAdministratorSeeder extends Seeder
{
    public function run(): void
    {
        // Never commit a known privileged password, including 'admin23'.
        $password = env('FIDUCREDIT_ADMIN_PASSWORD');
        if (!is_string($password) || mb_strlen(trim($password)) < 12 || strlen($password) > 72) {
            throw new RuntimeException('Configura FIDUCREDIT_ADMIN_PASSWORD con al menos 12 caracteres y máximo 72 bytes.');
        }

        $mfaSecret = env('FIDUCREDIT_ADMIN_MFA_SECRET');
        if (!is_string($mfaSecret) || !preg_match('/\\A[A-Z2-7]{32,128}\\z/', $mfaSecret)) {
            throw new RuntimeException('Configura FIDUCREDIT_ADMIN_MFA_SECRET con un secreto TOTP Base32 de al menos 32 caracteres.');
        }
        DB::transaction(function () use ($password, $mfaSecret): void {
            $existingRoot = User::where('is_superadmin', true)->lockForUpdate()->first();
            $existing = User::where('email', 'administrador@nahuicredit.com')->lockForUpdate()->first();

            if ($existingRoot && (!$existing || $existingRoot->id !== $existing->id)) {
                throw new RuntimeException('Ya existe un superadministrador distinto. No se creará otro ni se promoverá un usuario.');
            }
            if ($existing) {
                if (!$existing->is_superadmin) {
                    throw new RuntimeException('El correo ya pertenece a un usuario normal. Revisión manual obligatoria.');
                }
                // Repeatable and non-destructive: do not reset credentials of an existing administrator.
                return;
            }

            User::unguarded(fn () => User::create([
                'name' => 'Administrador FiduCredit',
                'email' => 'administrador@nahuicredit.com',
                'password' => $password,
                'is_superadmin' => true,
                'is_active' => true,
                'mfa_secret' => $mfaSecret,
                'role_id' => null,
            ]));
        }, 3);
    }
}
