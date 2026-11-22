<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowStep extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_steps';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function workflowVersion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditWorkflowVersion::class, 'workflow_version_id');
    }

    public function creditWorkflowTransitions(): HasMany
    {
        return $this->hasMany(CreditWorkflowTransition::class, 'from_step_id');
    }

    public function creditWorkflowStepRoles(): HasMany
    {
        return $this->hasMany(CreditWorkflowStepRole::class, 'step_id');
    }

    public function creditWorkflowStepRules(): HasMany
    {
        return $this->hasMany(CreditWorkflowStepRule::class, 'step_id');
    }

    public function creditWorkflowInstances(): HasMany
    {
        return $this->hasMany(CreditWorkflowInstance::class, 'current_step_id');
    }

    public function creditWorkflowTasks(): HasMany
    {
        return $this->hasMany(CreditWorkflowTask::class, 'step_id');
    }

    public function creditWorkflowSla(): HasMany
    {
        return $this->hasMany(CreditWorkflowSla::class, 'step_id');
    }
}
