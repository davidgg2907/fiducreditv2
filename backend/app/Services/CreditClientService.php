<?php

namespace App\Services;

use App\Models\CreditClient;
use App\Repositories\CreditClientRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreditClientService
{
    public function __construct(private readonly CreditClientRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditClient
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditClient
    {
        return DB::transaction(function () use ($attributes) {
            $client = $this->repository->create(Arr::except($attributes, ['addresses', 'bank_accounts']));
            $this->saveRelations($client, $attributes);
            return $client->refresh();
        });
    }

    public function update(string $id, array $attributes): CreditClient
    {
        return DB::transaction(function () use ($id, $attributes) {
            $client = CreditClient::query()->lockForUpdate()->findOrFail($id);
            $client = $this->repository->update($id, Arr::except($attributes, ['addresses', 'bank_accounts']));
            $this->saveRelations($client, $attributes);
            return $client->refresh();
        });
    }

    private function saveRelations(CreditClient $client, array $attributes): void
    {
        foreach ($attributes['addresses'] ?? [] as $data) {
            $parent = Arr::only($data, ['address_type', 'primary', 'active']);
            $address = isset($data['id'])
                ? $client->creditClientAddresses()->lockForUpdate()->findOrFail($data['id'])
                : $client->creditClientAddresses()->create($parent);
            $address->fill($parent)->save();
            if ($parent['primary'] && $parent['active']) {
                $client->creditClientAddresses()->where('id', '!=', $address->id)->update(['primary' => false]);
            }
            $version = Arr::except($data, ['id', 'address_type', 'primary', 'active']);
            $previous = $address->creditClientAddressVersions()->orderByDesc('version')->first();
            if ($previous && !$previous->fill($version)->isDirty()) {
                continue;
            }
            $now = now();
            if ($previous) {
                // Never persist edited historical fields.
                $previous->refresh();
                $previous->update(['valid_to' => $now]);
            }
            $address->creditClientAddressVersions()->create($version + [
                'version' => ($previous?->version ?? 0) + 1,
                'valid_from' => $now,
                'source' => 'customer',
            ]);
        }

        foreach ($attributes['bank_accounts'] ?? [] as $data) {
            $account = isset($data['id'])
                ? $client->creditClientBankAccounts()->lockForUpdate()->findOrFail($data['id'])
                : $client->creditClientBankAccounts()->make();
            $account->fill(Arr::except($data, ['id']));
            if (!$account->exists || $account->isDirty(['bank_code', 'bank_name', 'holder_name', 'clabe', 'account_last4', 'account_type'])) {
                if ($account->exists && ($account->creditApplications()->exists() || $account->creditDrawdowns()->exists() || $account->creditPayments()->exists())) {
                    throw ValidationException::withMessages(['bank_accounts' => 'La cuenta tiene operaciones asociadas. Registre una nueva cuenta para cambiar sus datos bancarios.']);
                }
                $account->verified = false;
            }
            $account->save();
            if ($account->primary && $account->active) {
                $client->creditClientBankAccounts()->where('id', '!=', $account->id)->update(['primary' => false]);
            }
        }
    }
}
