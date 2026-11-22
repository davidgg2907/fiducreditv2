<?php

namespace App\Services;

use App\Models\CreditApplicationEvent;
use App\Repositories\CreditApplicationEventRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationEventService
{
    public function __construct(private readonly CreditApplicationEventRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationEvent
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationEvent
    {
        abort(405, 'Operación de dominio requerida.');
    }

    public function update(string $id, array $attributes): CreditApplicationEvent
    {
        abort(405, 'Operación de dominio requerida.');
    }
}
