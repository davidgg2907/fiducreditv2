<?php

namespace App\Services;

use App\Models\CreditBusinessCalendar;
use App\Repositories\CreditBusinessCalendarRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditBusinessCalendarService
{
    public function __construct(private readonly CreditBusinessCalendarRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditBusinessCalendar
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditBusinessCalendar
    {
        return DB::transaction(
            fn (): CreditBusinessCalendar => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditBusinessCalendar
    {
        return DB::transaction(
            fn (): CreditBusinessCalendar => $this->repository->update($id, $attributes)
        );
    }
}
