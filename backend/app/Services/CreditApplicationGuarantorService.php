<?php

namespace App\Services;

use App\Models\CreditApplicationGuarantor;
use App\Repositories\CreditApplicationGuarantorRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationGuarantorService
{
    public function __construct(private readonly CreditApplicationGuarantorRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationGuarantor
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationGuarantor
    {
        return DB::transaction(
            fn (): CreditApplicationGuarantor => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationGuarantor
    {
        return DB::transaction(
            fn (): CreditApplicationGuarantor => $this->repository->update($id, $attributes)
        );
    }
}
