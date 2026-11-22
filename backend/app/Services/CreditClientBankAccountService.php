<?php

namespace App\Services;

use App\Models\CreditClientBankAccount;
use App\Repositories\CreditClientBankAccountRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditClientBankAccountService
{
    public function __construct(private readonly CreditClientBankAccountRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditClientBankAccount
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditClientBankAccount
    {
        return DB::transaction(
            fn (): CreditClientBankAccount => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditClientBankAccount
    {
        return DB::transaction(
            fn (): CreditClientBankAccount => $this->repository->update($id, $attributes)
        );
    }
}
