<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditAdvisor extends Model
{
    use HasUuids;

    protected $table = 'credit_advisors';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditBranch::class, 'branch_id');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'advisor_id');
    }
}
