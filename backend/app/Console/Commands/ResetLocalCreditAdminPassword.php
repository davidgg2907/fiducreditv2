<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\AuthTokenRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class ResetLocalCreditAdminPassword extends Command
{
    protected $signature = 'access:reset-local-admin-password';
    protected $description = 'Restablece interactivamente la contraseña del superadministrador en desarrollo local';

    public function handle(AuthTokenRepository $tokens): int
    {
        if (!app()->environment('local')) {
            $this->error('Este comando solo está disponible cuando APP_ENV=local.');

            return self::FAILURE;
        }

        $admins = User::query()->where('is_superadmin', true)->get(['id', 'email', 'is_active']);
        if ($admins->count() !== 1) {
            $this->error('Se requiere exactamente un superadministrador. Encontrados: '.$admins->count());

            return self::FAILURE;
        }

        $admin = $admins->first();
        $this->line('Cuenta: '.$admin->email);
        if (!$this->confirm('¿Restablecer la contraseña y cerrar sus sesiones existentes?', false)) {
            return self::FAILURE;
        }

        $password = (string) $this->secret('Nueva contraseña (12 caracteres como mínimo y 72 bytes como máximo)');
        $confirmation = (string) $this->secret('Repite la nueva contraseña');

        if (mb_strlen($password) < 12 || strlen($password) > 72 || !hash_equals($password, $confirmation)) {
            $this->error('Contraseña inválida o confirmación diferente.');

            return self::FAILURE;
        }

        DB::transaction(function () use ($admin, $password, $tokens): void {
            $user = User::query()->lockForUpdate()->findOrFail($admin->id);
            $user->password = $password;
            $user->is_active = true;
            $user->save();
            $tokens->revokeForUser($user->id);
        }, 3);

        $this->info('Contraseña actualizada. El autenticador MFA existente permanece habilitado.');
        $this->line('Utiliza el correo mostrado y un código vigente del autenticador.');

        return self::SUCCESS;
    }
}
