<?php

namespace App\Services;

use App\Models\CreditContract;
use App\Repositories\CreditContractRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditContractService
{
    public function __construct(private readonly CreditContractRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditContract
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditContract
    {
        abort(405, 'Operación de dominio requerida.');
    }

    public function update(string $id, array $attributes): CreditContract
    {
        abort(405, 'Operación de dominio requerida.');
    }
}
