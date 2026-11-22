<?php

namespace App\Services;

use App\Models\PldCaseEvent;
use App\Repositories\PldCaseEventRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldCaseEventService
{
    public function __construct(private readonly PldCaseEventRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldCaseEvent
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldCaseEvent
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldCaseEvent => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldCaseEvent
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldCaseEvent => $this->repository->update($id, $attributes)
        );
    }
}
