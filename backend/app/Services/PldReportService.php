<?php

namespace App\Services;

use App\Models\PldReport;
use App\Repositories\PldReportRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldReportService
{
    public function __construct(private readonly PldReportRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldReport
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldReport
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldReport => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldReport
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldReport => $this->repository->update($id, $attributes)
        );
    }
}
