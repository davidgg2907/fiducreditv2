<?php

namespace App\Services;

use App\Models\CreditBureauInquiry;
use App\Repositories\CreditBureauInquiryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditBureauInquiryService
{
    public function __construct(private readonly CreditBureauInquiryRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditBureauInquiry
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditBureauInquiry
    {
        return DB::transaction(
            fn (): CreditBureauInquiry => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditBureauInquiry
    {
        return DB::transaction(
            fn (): CreditBureauInquiry => $this->repository->update($id, $attributes)
        );
    }
}
