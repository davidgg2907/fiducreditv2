<?php

namespace App\Services;

use App\Models\CreditPayoffQuoteItem;
use App\Repositories\CreditPayoffQuoteItemRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPayoffQuoteItemService
{
    public function __construct(private readonly CreditPayoffQuoteItemRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPayoffQuoteItem
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPayoffQuoteItem
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPayoffQuoteItem => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPayoffQuoteItem
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPayoffQuoteItem => $this->repository->update($id, $attributes)
        );
    }
}
