<?php

namespace App\Services;

use App\Models\CreditApplicationStatusHistory;
use App\Repositories\CreditApplicationStatusHistoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationStatusHistoryService
{
    public function __construct(private readonly CreditApplicationStatusHistoryRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationStatusHistory
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationStatusHistory
    {
        abort(405, 'Operación de dominio requerida.');
    }

    public function update(string $id, array $attributes): CreditApplicationStatusHistory
    {
        abort(405, 'Operación de dominio requerida.');
    }
}
