<?php

namespace App\Services;

use App\Models\CreditWorkflow;
use App\Models\CreditProduct;
use App\Repositories\CreditWorkflowRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreditWorkflowService
{
    public function __construct(private readonly CreditWorkflowRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflow
    {
        $record = $this->repository->findOrFail($id, $include);
        return $this->configuration($record);
    }

    private function configuration(CreditWorkflow $record): CreditWorkflow
    {
        $version = $record->creditWorkflowVersions()->orderByDesc('version')->first();
        if ($version) {
            $version->load(['creditWorkflowSteps' => fn ($q) => $q->orderBy('sort_order'),
                'creditWorkflowSteps.creditWorkflowStepRoles',
                'creditWorkflowSteps.creditWorkflowStepRules',
                'creditWorkflowTransitions']);
        }
        $record->setRelation('configurationVersion', $version);
        return $record;
    }

    public function create(array $attributes): CreditWorkflow
    {
        return DB::transaction(function () use ($attributes) {
            $general = Arr::except($attributes, ['steps', 'source_version_id']);
            $this->validateProduct($general['company_id'], $general['product_id'] ?? null);
            $record = $this->repository->create($general);
            if (array_key_exists('steps', $attributes)) {
                $this->saveVersion($record, $attributes['steps'], $attributes['source_version_id'] ?? null);
            }
            return $this->configuration($record);
        });
    }

    public function update(string $id, array $attributes): CreditWorkflow
    {
        return DB::transaction(function () use ($id, $attributes) {
            $record = CreditWorkflow::query()->lockForUpdate()->findOrFail($id);
            $general = Arr::except($attributes, ['steps', 'source_version_id', 'created_by']);
            $company = $general['company_id'] ?? $record->company_id;
            $product = array_key_exists('product_id', $general) ? $general['product_id'] : $record->product_id;
            $this->validateProduct($company, $product);
            if ($record->creditWorkflowVersions()->exists() &&
                ($company !== $record->company_id || $product !== $record->product_id)) {
                throw ValidationException::withMessages(['company_id' => 'No se puede cambiar la empresa o producto de un flujo versionado.']);
            }
            $record = $this->repository->update($id, $general);
            if (array_key_exists('steps', $attributes)) {
                $this->saveVersion($record, $attributes['steps'], $attributes['source_version_id'] ?? null);
            }
            return $this->configuration($record);
        });
    }

    private function validateProduct(string $company, ?string $product): void
    {
        if ($product && !CreditProduct::query()->whereKey($product)->where('company_id', $company)->exists()) {
            throw ValidationException::withMessages(['product_id' => 'El producto no pertenece a la empresa.']);
        }
    }

    private function saveVersion(CreditWorkflow $record, array $steps, ?string $sourceId): void
    {
        $source = $record->creditWorkflowVersions()->orderByDesc('version')->first();
        if ($source?->id !== $sourceId) {
            throw ValidationException::withMessages(['source_version_id' => 'La configuración cambió. Recarga el flujo antes de guardar.']);
        }
        $oldSteps = $source ? $source->creditWorkflowSteps()->with('creditWorkflowSla')->get()->keyBy('id') : collect();
        $oldTransitions = $source ? $source->creditWorkflowTransitions()->get()->keyBy('id') : collect();
        $version = $record->creditWorkflowVersions()->create([
            'version' => ($source?->version ?? 0) + 1,
            'status' => 'draft',
            'is_default' => false,
        ]);
        $map = [];
        $created = [];
        foreach (array_values($steps) as $index => $row) {
            $oldId = $row['id'] ?? null;
            if ($oldId && !$oldSteps->has($oldId)) {
                throw ValidationException::withMessages(['steps' => 'Una etapa no pertenece a la versión del flujo.']);
            }
            $step = $version->creditWorkflowSteps()->create(
                Arr::except($row, ['id','rules','roles']) + ['sort_order' => $index + 1]
            );
            $created[] = $step;
            if ($oldId) {
                $map[$oldId] = $step->id;
                $sla = $oldSteps[$oldId]->creditWorkflowSla()->first();
                if ($sla) {
                    $step->creditWorkflowSla()->create(Arr::except($sla->getAttributes(), ['id','step_id','created_at','updated_at']));
                }
            }
            $roleIds = array_column($row['roles'], 'role_id');
            $ruleCodes = array_map(fn ($r) => mb_strtolower($r['code']), $row['rules']);
            if (count(array_unique($roleIds)) !== count($roleIds) || count(array_unique($ruleCodes)) !== count($ruleCodes)) {
                throw ValidationException::withMessages(['steps' => 'No se permiten roles o códigos de reglas duplicados dentro de una etapa.']);
            }
            foreach ($row['roles'] as $role) {
                $step->creditWorkflowStepRoles()->create($role);
            }
        }
        $transitionMap = [];
        foreach ($oldTransitions as $transition) {
            if (!isset($map[$transition->from_step_id], $map[$transition->to_step_id])) {
                throw ValidationException::withMessages(['steps' => 'No se puede retirar una etapa vinculada a una transición.']);
            }
            $copy = $version->creditWorkflowTransitions()->create(
                Arr::except($transition->getAttributes(), ['id','workflow_version_id','from_step_id','to_step_id','created_at','updated_at']) +
                ['from_step_id' => $map[$transition->from_step_id], 'to_step_id' => $map[$transition->to_step_id]]
            );
            $transitionMap[$transition->id] = $copy->id;
        }
        foreach (array_values($steps) as $index => $row) {
            foreach ($row['rules'] as $rule) {
                $transitionId = $rule['transition_id'] ?? null;
                if ($transitionId && (!isset($transitionMap[$transitionId]) || $oldTransitions[$transitionId]->from_step_id !== ($row['id'] ?? null))) {
                    throw ValidationException::withMessages(['steps' => 'La transición de la regla no pertenece a la etapa.']);
                }
                $rule['transition_id'] = $transitionId ? $transitionMap[$transitionId] : null;
                $created[$index]->creditWorkflowStepRules()->create($rule);
            }
        }
    }
}
