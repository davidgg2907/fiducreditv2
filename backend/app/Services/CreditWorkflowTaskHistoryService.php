<?php

namespace App\Services;

use App\Models\CreditWorkflowTaskHistory;
use App\Repositories\CreditWorkflowTaskHistoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowTaskHistoryService
{
    public function __construct(private readonly CreditWorkflowTaskHistoryRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowTaskHistory
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowTaskHistory
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditWorkflowTaskHistory => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowTaskHistory
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditWorkflowTaskHistory => $this->repository->update($id, $attributes)
        );
    }
}
