<?php

namespace App\Services;

use App\Models\CreditBusinessHoliday;
use App\Repositories\CreditBusinessHolidayRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditBusinessHolidayService
{
    public function __construct(private readonly CreditBusinessHolidayRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditBusinessHoliday
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditBusinessHoliday
    {
        return DB::transaction(
            fn (): CreditBusinessHoliday => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditBusinessHoliday
    {
        return DB::transaction(
            fn (): CreditBusinessHoliday => $this->repository->update($id, $attributes)
        );
    }
}
