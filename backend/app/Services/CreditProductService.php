<?php

namespace App\Services;

use App\Models\CreditProduct;
use App\Models\CreditProductVersion;
use App\Repositories\CreditProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreditProductService
{
    private const SECTIONS = [
        'rules' => 'creditProductRules',
        'fields' => 'creditProductFields',
        'documents' => 'creditProductDocuments',
        'fees' => 'creditProductFees',
    ];

    public function __construct(private readonly CreditProductRepository $repository) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProduct
    {
        return $this->repository->findOrFail($id, $include)->load([
            'currentVersion.creditProductRules', 'currentVersion.creditProductFields',
            'currentVersion.creditProductDocuments', 'currentVersion.creditProductFees',
            'creditProductVersions' => fn ($query) => $query->orderByDesc('version')->with(['creditProductRules','creditProductFields','creditProductDocuments','creditProductFees']),
        ]);
    }

    public function create(array $attributes): CreditProduct
    {
        return DB::transaction(function () use ($attributes) {
            $product = $this->repository->create(Arr::except($attributes, ['configuration', ...array_keys(self::SECTIONS)]));
            return $this->publish($product, $attributes, null, true);
        }, 3);
    }

    public function update(string $id, array $attributes): CreditProduct
    {
        return DB::transaction(function () use ($id, $attributes) {
            $product = CreditProduct::query()->lockForUpdate()->findOrFail($id);
            $previous = $product->creditProductVersions()->where('active', true)->orderByDesc('version')->first();
            $product->fill(Arr::except($attributes, ['configuration', ...array_keys(self::SECTIONS)]));
            $changed = $product->isDirty();
            $product->save();
            return $this->publish($product, $attributes, $previous, $changed);
        }, 3);
    }

    private function publish(CreditProduct $product, array $attributes, ?CreditProductVersion $previous, bool $changed): CreditProduct
    {
        $config = $attributes['configuration'] ?? [];
        $version = $previous ? $previous->replicate() : new CreditProductVersion();
        $version->fill($config);
        foreach (['amount', 'term', 'annual_rate', 'dti'] as $range) {
            $min = $version->{'min_'.$range};
            $max = $version->{'max_'.$range};
            if (($range !== 'dti' && ($min === null || $max === null)) ||
                ($min !== null && $max !== null && ($min < 0 || $max < $min)) ||
                ($range === 'term' && $min < 1)) {
                throw ValidationException::withMessages(['configuration' => 'Intervalo inválido: '.$range]);
            }
        }

        $changed = $changed || !$previous || $version->getAttributes() != $previous->replicate()->getAttributes();
        $rows = [];
        foreach (self::SECTIONS as $section => $relation) {
            $old = $previous ? $previous->{$relation}()->get()->map(fn ($row) => Arr::except($row->attributesToArray(), ['id', 'product_version_id', 'created_at', 'updated_at']))->all() : [];
            $rows[$section] = $attributes[$section] ?? $old;
            if (array_key_exists($section, $attributes) && $rows[$section] != $old) {
                $changed = true;
            }
        }
        if (!$changed) {
            return $this->find($product->id);
        }

        $version->product_id = $product->id;
        $version->version = ((int) $product->creditProductVersions()->max('version')) + 1;
        $version->active = true;
        $version->effective_from = now();
        $version->effective_to = null;
        $version->product_snapshot = Arr::except($product->getAttributes(), ['created_at', 'updated_at']);
        $version->changed_by = auth()->id();
        $version->save();

        foreach (self::SECTIONS as $section => $relation) {
            foreach ($rows[$section] as $row) {
                $version->{$relation}()->create($row);
            }
        }

        if ($previous) {
            foreach (['creditLinePolicies', 'creditProductCalendars', 'pldProductPolicies'] as $relation) {
                foreach ($previous->{$relation}()->get() as $record) {
                    $copy = $record->replicate();
                    $copy->product_version_id = $version->id;
                    $copy->save();
                }
            }
            foreach ($previous->creditPaymentApplicationPolicies()->with('creditPaymentApplicationPriorities')->get() as $policy) {
                $copy = $policy->replicate();
                $copy->product_version_id = $version->id;
                $copy->save();
                foreach ($policy->creditPaymentApplicationPriorities as $priority) {
                    $priorityCopy = $priority->replicate();
                    $priorityCopy->policy_id = $copy->id;
                    $priorityCopy->save();
                }
            }
        }
        $product->creditProductVersions()->where('id', '!=', $version->id)->where('active', true)
            ->update(['active' => false, 'effective_to' => now()]);
        return $this->find($product->id);
    }
}
