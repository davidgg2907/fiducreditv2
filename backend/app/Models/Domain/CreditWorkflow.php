<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditWorkflow extends Model
{
    use HasUuids;

    protected $table = 'credit_workflows';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditProduct::class, 'product_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function creditWorkflowVersions(): HasMany
    {
        return $this->hasMany(CreditWorkflowVersion::class, 'workflow_id');
    }
}
