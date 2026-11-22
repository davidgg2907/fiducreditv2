<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowTask extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_tasks';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(CreditWorkflowInstance::class, 'instance_id');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(CreditWorkflowStep::class, 'step_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(CreditBranch::class, 'branch_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function assignedRole(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Role::class, 'assigned_role_id');
    }

    public function creditWorkflowTaskHistory(): HasMany
    {
        return $this->hasMany(CreditWorkflowTaskHistory::class, 'task_id');
    }
}
