<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldPolicyVersion extends Model
{
    use HasUuids;

    protected $table = 'pld_policy_versions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'monitoring_config' => 'array',
        ];
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(PldPolicy::class, 'policy_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function pldRules(): HasMany
    {
        return $this->hasMany(PldRule::class, 'policy_version_id');
    }

    public function pldProductPolicies(): HasMany
    {
        return $this->hasMany(PldProductPolicy::class, 'policy_version_id');
    }

    public function pldClientProfiles(): HasMany
    {
        return $this->hasMany(PldClientProfile::class, 'policy_version_id');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'policy_version_id');
    }
}
