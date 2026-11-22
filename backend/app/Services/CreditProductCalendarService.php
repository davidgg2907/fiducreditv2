<?php

namespace App\Services;

use App\Models\CreditProductCalendar;
use App\Repositories\CreditProductCalendarRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductCalendarService
{
    public function __construct(private readonly CreditProductCalendarRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProductCalendar
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditProductCalendar
    {
        return DB::transaction(
            fn (): CreditProductCalendar => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProductCalendar
    {
        return DB::transaction(
            fn (): CreditProductCalendar => $this->repository->update($id, $attributes)
        );
    }
}
