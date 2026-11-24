<?php

namespace App\Services;

use App\Models\CreditAdvisor;
use App\Models\User;
use App\Repositories\AuthTokenRepository;
use App\Repositories\CreditAdvisorRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreditAdvisorService
{
    public function __construct(private readonly CreditAdvisorRepository $repository, private readonly AuthTokenRepository $tokens) {}

    public function paginate(array $filters = []): LengthAwarePaginator { return $this->repository->paginate($filters); }
    public function find(string $id, string $include = ''): CreditAdvisor { return $this->repository->findOrFail($id, $include); }

    public function create(array $attributes): CreditAdvisor
    {
        return DB::transaction(function () use ($attributes): CreditAdvisor {
            $newUser = $attributes['new_user'] ?? null;
            unset($attributes['new_user']);
            if (!($attributes['has_system_access'] ?? false)) {
                $attributes['user_id'] = null;
            } elseif (empty($attributes['user_id'])) {
                $attributes['user_id'] = $this->createAccount($newUser);
            } else {
                $this->assertAccountIsAllowed((int)$attributes['user_id']);
            }
            return $this->repository->create($attributes);
        }, 3);
    }

    public function update(string $id, array $attributes): CreditAdvisor
    {
        return DB::transaction(function () use ($id, $attributes): CreditAdvisor {
            $existing = CreditAdvisor::query()->lockForUpdate()->findOrFail($id);
            $newUser = $attributes['new_user'] ?? null;
            unset($attributes['new_user']);
            $hasAccess = $attributes['has_system_access'] ?? (bool)$existing->has_system_access;
            $userId = $attributes['user_id'] ?? $existing->user_id;

            if ($hasAccess && !$userId) {
                $userId = $this->createAccount($newUser);
                $attributes['user_id'] = $userId;
            }
            if ($hasAccess && $userId) {
                $this->assertAccountIsAllowed((int)$userId);
                $target = User::query()->lockForUpdate()->findOrFail($userId);
                $target->is_active = true;
                $target->save();
            }
            if (!$hasAccess && $userId) {
                $this->assertAccountIsAllowed((int)$userId);
                $target = User::query()->lockForUpdate()->findOrFail($userId);
                $target->is_active = false;
                $target->save();
                $this->tokens->revokeForUser((int)$userId);
                $attributes['user_id'] = $userId; // conservar trazabilidad del asesor
            }
            return $this->repository->update($id, $attributes);
        }, 3);
    }

    private function createAccount(?array $data): int
    {
        if (!$data || empty($data['name']) || empty($data['email']) || empty($data['password'])
            || empty($data['role_id']) || ($data['password'] !== ($data['password_confirmation'] ?? null))) {
            throw ValidationException::withMessages(['new_user' => 'Captura nombre, correo, contraseña confirmada y rol para habilitar el acceso.']);
        }
        $user = new User();
        $user->name = $data['name'];
        $user->email = strtolower(trim($data['email']));
        $user->password = $data['password'];
        $user->role_id = $data['role_id'];
        $user->is_active = true;
        $user->is_superadmin = false;
        $user->save();
        return (int)$user->id;
    }
    private function assertAccountIsAllowed(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->is_superadmin) throw ValidationException::withMessages(['user_id' => 'El superadministrador no puede asociarse como asesor.']);
    }
}
