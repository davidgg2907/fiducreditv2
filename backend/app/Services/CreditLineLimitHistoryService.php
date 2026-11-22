<?php

namespace App\Services;

use App\Models\CreditLineLimitHistory;
use App\Repositories\CreditLineLimitHistoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLineLimitHistoryService
{
    public function __construct(private readonly CreditLineLimitHistoryRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLineLimitHistory
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLineLimitHistory
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLineLimitHistory => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLineLimitHistory
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLineLimitHistory => $this->repository->update($id, $attributes)
        );
    }
}
