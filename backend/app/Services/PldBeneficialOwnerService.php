<?php

namespace App\Services;

use App\Models\PldBeneficialOwner;
use App\Repositories\PldBeneficialOwnerRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldBeneficialOwnerService
{
    public function __construct(private readonly PldBeneficialOwnerRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldBeneficialOwner
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldBeneficialOwner
    {
        return DB::transaction(
            fn (): PldBeneficialOwner => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldBeneficialOwner
    {
        return DB::transaction(
            fn (): PldBeneficialOwner => $this->repository->update($id, $attributes)
        );
    }
}
