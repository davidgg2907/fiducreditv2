<?php

namespace App\Services;

use App\Models\PldMonitoringEvent;
use App\Repositories\PldMonitoringEventRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldMonitoringEventService
{
    public function __construct(private readonly PldMonitoringEventRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldMonitoringEvent
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldMonitoringEvent
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldMonitoringEvent => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldMonitoringEvent
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldMonitoringEvent => $this->repository->update($id, $attributes)
        );
    }
}
