<?php

namespace App\Services;

use App\Models\CreditAmortizationInstallment;
use App\Repositories\CreditAmortizationInstallmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditAmortizationInstallmentService
{
    public function __construct(private readonly CreditAmortizationInstallmentRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditAmortizationInstallment
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditAmortizationInstallment
    {
        abort(405, 'Operación de dominio requerida.');
    }

    public function update(string $id, array $attributes): CreditAmortizationInstallment
    {
        abort(405, 'Operación de dominio requerida.');
    }
}
