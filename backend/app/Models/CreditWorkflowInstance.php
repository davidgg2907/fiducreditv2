<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowInstance extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_instances';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'application_id');
    }

    public function workflowVersion(): BelongsTo
    {
        return $this->belongsTo(CreditWorkflowVersion::class, 'workflow_version_id');
    }

    public function currentStep(): BelongsTo
    {
        return $this->belongsTo(CreditWorkflowStep::class, 'current_step_id');
    }

    public function startedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'started_by');
    }

    public function creditWorkflowTasks(): HasMany
    {
        return $this->hasMany(CreditWorkflowTask::class, 'instance_id');
    }
}
