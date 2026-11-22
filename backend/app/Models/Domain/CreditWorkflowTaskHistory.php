<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflowTaskHistory extends Model
{
    use HasUuids;

    protected $table = 'credit_workflow_task_history';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(CreditWorkflowTask::class, 'task_id');
    }

    public function previousAssignee(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'previous_assignee');
    }
}
