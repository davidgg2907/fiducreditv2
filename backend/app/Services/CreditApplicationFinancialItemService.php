<?php

namespace App\Services;

use App\Models\CreditApplication;
use App\Models\CreditApplicationFinancialItem;
use App\Repositories\CreditApplicationFinancialItemRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreditApplicationFinancialItemService
{
    public function __construct(
        private readonly CreditApplicationFinancialItemRepository $repository
    ) {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationFinancialItem
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $data, int $actorId): CreditApplicationFinancialItem
    {
        return DB::transaction(function () use ($data, $actorId): CreditApplicationFinancialItem {
            $application = CreditApplication::query()
                ->lockForUpdate()
                ->findOrFail($data['application_id']);

            if ($application->status !== 'captured') {
                throw ValidationException::withMessages([
                    'application_id' => 'La solicitud no está en captura.',
                ]);
            }

            return $this->repository->create([
                ...$data,
                'captured_by' => $actorId,
                'verified' => false,
            ]);
        });
    }

    public function update(string $id, array $data): CreditApplicationFinancialItem
    {
        return DB::transaction(function () use ($id, $data): CreditApplicationFinancialItem {
            $item = $this->repository->findOrFail($id);
            $application = CreditApplication::query()
                ->lockForUpdate()
                ->findOrFail($item->application_id);

            if ($application->status !== 'captured') {
                throw ValidationException::withMessages([
                    'application_id' => 'La solicitud no está en captura.',
                ]);
            }

            return $this->repository->update($id, $data);
        });
    }

    public function createBatch(string $applicationId, array $items, int $actorId): Collection
    {
        return DB::transaction(function () use (
            $applicationId,
            $items,
            $actorId
        ): Collection {
            $application = CreditApplication::query()
                ->lockForUpdate()
                ->findOrFail($applicationId);

            if ($application->status !== 'captured') {
                throw ValidationException::withMessages([
                    'application_id' => 'La solicitud no está en captura.',
                ]);
            }

            return $this->repository->insertBatch(
                $applicationId,
                $items,
                $actorId
            );
        });
    }
}
