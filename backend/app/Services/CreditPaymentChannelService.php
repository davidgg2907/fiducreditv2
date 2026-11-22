<?php

namespace App\Services;

use App\Models\CreditPaymentChannel;
use App\Repositories\CreditPaymentChannelRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPaymentChannelService
{
    public function __construct(private readonly CreditPaymentChannelRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPaymentChannel
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPaymentChannel
    {
        return DB::transaction(
            fn (): CreditPaymentChannel => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPaymentChannel
    {
        return DB::transaction(
            fn (): CreditPaymentChannel => $this->repository->update($id, $attributes)
        );
    }
}
