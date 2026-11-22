<?php

namespace App\Services;

use App\Models\PldClientProfile;
use App\Repositories\PldClientProfileRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldClientProfileService
{
    public function __construct(private readonly PldClientProfileRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldClientProfile
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldClientProfile
    {
        return DB::transaction(
            fn (): PldClientProfile => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldClientProfile
    {
        return DB::transaction(
            fn (): PldClientProfile => $this->repository->update($id, $attributes)
        );
    }
}
