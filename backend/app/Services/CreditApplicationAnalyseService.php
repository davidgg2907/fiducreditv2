<?php

namespace App\Services;

use App\Models\CreditApplicationAnalyse;
use App\Repositories\CreditApplicationAnalyseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationAnalyseService
{
    public function __construct(private readonly CreditApplicationAnalyseRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationAnalyse
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationAnalyse
    {
        return DB::transaction(
            fn (): CreditApplicationAnalyse => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationAnalyse
    {
        return DB::transaction(
            fn (): CreditApplicationAnalyse => $this->repository->update($id, $attributes)
        );
    }
}
