<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowTransition extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_transitions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function workflowVersion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditWorkflowVersion::class, 'workflow_version_id');
    }

    public function fromStep(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditWorkflowStep::class, 'from_step_id');
    }

    public function creditWorkflowStepRules(): HasMany
    {
        return $this->hasMany(CreditWorkflowStepRule::class, 'transition_id');
    }
}
