<?php

namespace App\Services;

use App\Models\CreditAmortizationSchedule;
use App\Repositories\CreditAmortizationScheduleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditAmortizationScheduleService
{
    public function __construct(private readonly CreditAmortizationScheduleRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditAmortizationSchedule
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditAmortizationSchedule
    {
        abort(405, 'Operación de dominio requerida.');
    }

    public function update(string $id, array $attributes): CreditAmortizationSchedule
    {
        abort(405, 'Operación de dominio requerida.');
    }
}
