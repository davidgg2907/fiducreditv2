<?php

namespace App\Services;

use App\Models\CreditPayment;
use App\Repositories\CreditPaymentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPaymentService
{
    public function __construct(private readonly CreditPaymentRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPayment
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPayment
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPayment => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPayment
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPayment => $this->repository->update($id, $attributes)
        );
    }
}
