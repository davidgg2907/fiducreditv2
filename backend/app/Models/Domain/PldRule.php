<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldRule extends Model
{
    use HasUuids;

    protected $table = 'pld_rules';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\PldPolicyVersion::class, 'policy_version_id');
    }

    public function pldAlerts(): HasMany
    {
        return $this->hasMany(PldAlert::class, 'rule_id');
    }
}
