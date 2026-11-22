<?php

namespace App\Services;

use App\Models\CreditApplicationDocument;
use App\Repositories\CreditApplicationDocumentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationDocumentService
{
    public function __construct(private readonly CreditApplicationDocumentRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationDocument
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationDocument
    {
        abort(405, 'La persistencia documental requiere un caso de uso seguro.');

        return DB::transaction(
            fn (): CreditApplicationDocument => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationDocument
    {
        abort(405, 'La persistencia documental requiere un caso de uso seguro.');

        return DB::transaction(
            fn (): CreditApplicationDocument => $this->repository->update($id, $attributes)
        );
    }
}
