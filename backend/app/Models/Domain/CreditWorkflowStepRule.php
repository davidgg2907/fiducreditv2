<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowStepRule extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_step_rules';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function step(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditWorkflowStep::class, 'step_id');
    }

    public function transition(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditWorkflowTransition::class, 'transition_id');
    }
}
