<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\AuthTokenRepository;
use App\Services\Totp;
use Illuminate\Console\Command;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\OutputInterface;

final class BootstrapAccess extends Command
{
    protected $signature = 'access:bootstrap {--renew-mfa : Renueva el autenticador del superadministrador existente}';

    protected $description = 'Crea el superadministrador inicial y genera su secreto TOTP';

    public function handle(Totp $totp): int
    {
        if ($this->option('renew-mfa')) {
            return $this->renewMfa($totp);
        }
        if (User::where('is_superadmin', true)->exists()) {
            $this->error('Ya existe un superadministrador.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Nombre del superadministrador', 'Root'));
        $email = strtolower(trim((string) $this->ask('Correo electrónico')));
        $password = (string) $this->secret('Contraseña (mínimo 12 caracteres, máximo 72 bytes)');
        $confirmation = (string) $this->secret('Repita la contraseña');

        if ($name === '' || mb_strlen($name) > 255 || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || mb_strlen($password) < 12 || strlen($password) > 72 || $password !== $confirmation) {
            $this->error('Datos incompletos o contraseña inválida.');

            return self::FAILURE;
        }

        $secret = $totp->generateSecret();
        $user = new User(['name' => $name, 'email' => $email, 'password' => $password]);
        $user->is_superadmin = true;
        $user->mfa_secret = $secret;
        try {
            $user->save();
        } catch (UniqueConstraintViolationException) {
            $this->error('Ya existe un superadministrador o el correo está registrado.');

            return self::FAILURE;
        }

        $this->showSecret($secret);

        return self::SUCCESS;
    }

    private function renewMfa(Totp $totp): int
    {
        $user = User::where('is_superadmin', true)->first();
        if (!$user || !$this->confirm('¿Renovar el autenticador y cerrar la sesión del superadministrador?')) {
            return self::FAILURE;
        }

        $secret = $totp->generateSecret();
        DB::transaction(function () use ($user, $secret) {
            $current = User::lockForUpdate()->findOrFail($user->id);
            $current->mfa_secret = $secret;
            $current->mfa_last_step = null;
            $current->save();
            app(AuthTokenRepository::class)->revokeForUser($current->id);
        }, 3);
        $this->showSecret($secret);

        return self::SUCCESS;
    }

    private function showSecret(string $secret): void
    {
        $this->info('Configura tu aplicación de autenticación con esta clave TOTP (SHA-1, 6 dígitos, 30 segundos).');
        // Write the secret as raw console output, avoiding formatter interpretation.
        $this->output->writeln($secret, OutputInterface::OUTPUT_RAW);
    }
}
