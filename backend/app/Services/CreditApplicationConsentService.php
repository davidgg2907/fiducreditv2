<?php

namespace App\Services;

use App\Models\CreditApplicationConsent;
use App\Repositories\CreditApplicationConsentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationConsentService
{
    public function __construct(private readonly CreditApplicationConsentRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationConsent
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationConsent
    {
        return DB::transaction(
            fn (): CreditApplicationConsent => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationConsent
    {
        return DB::transaction(
            fn (): CreditApplicationConsent => $this->repository->update($id, $attributes)
        );
    }
}
