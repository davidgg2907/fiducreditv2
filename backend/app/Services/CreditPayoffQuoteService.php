<?php

namespace App\Services;

use App\Models\CreditPayoffQuote;
use App\Repositories\CreditPayoffQuoteRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPayoffQuoteService
{
    public function __construct(private readonly CreditPayoffQuoteRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPayoffQuote
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPayoffQuote
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPayoffQuote => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPayoffQuote
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPayoffQuote => $this->repository->update($id, $attributes)
        );
    }
}
