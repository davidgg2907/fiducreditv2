<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowVersion extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_versions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(CreditWorkflow::class, 'workflow_id');
    }

    public function publishedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'published_by');
    }

    public function creditWorkflowSteps(): HasMany
    {
        return $this->hasMany(CreditWorkflowStep::class, 'workflow_version_id');
    }

    public function creditWorkflowTransitions(): HasMany
    {
        return $this->hasMany(CreditWorkflowTransition::class, 'workflow_version_id');
    }

    public function creditWorkflowInstances(): HasMany
    {
        return $this->hasMany(CreditWorkflowInstance::class, 'workflow_version_id');
    }
}
