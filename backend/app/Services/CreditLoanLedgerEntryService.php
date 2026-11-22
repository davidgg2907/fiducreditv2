<?php

namespace App\Services;

use App\Models\CreditLoanLedgerEntry;
use App\Repositories\CreditLoanLedgerEntryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanLedgerEntryService
{
    public function __construct(private readonly CreditLoanLedgerEntryRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanLedgerEntry
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanLedgerEntry
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanLedgerEntry => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanLedgerEntry
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanLedgerEntry => $this->repository->update($id, $attributes)
        );
    }
}
