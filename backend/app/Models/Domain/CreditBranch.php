<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditBranch extends Model
{
    use HasUuids;

    protected $table = 'credit_branches';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CreditCompany::class, 'company_id');
    }

    public function creditAdvisors(): HasMany
    {
        return $this->hasMany(CreditAdvisor::class, 'branch_id');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'branch_id');
    }

    public function creditWorkflowTasks(): HasMany
    {
        return $this->hasMany(CreditWorkflowTask::class, 'branch_id');
    }
}
