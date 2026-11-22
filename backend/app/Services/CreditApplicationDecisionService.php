<?php

namespace App\Services;

use App\Models\CreditApplicationDecision;
use App\Repositories\CreditApplicationDecisionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationDecisionService
{
    public function __construct(private readonly CreditApplicationDecisionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationDecision
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationDecision
    {
        abort(405, 'Operación de dominio requerida.');
    }

    public function update(string $id, array $attributes): CreditApplicationDecision
    {
        abort(405, 'Operación de dominio requerida.');
    }
}
