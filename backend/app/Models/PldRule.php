<?php

namespace App\Models;

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

    protected function casts(): array
    {
        return [
            'parameters' => 'array',
        ];
    }

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(PldPolicyVersion::class, 'policy_version_id');
    }

    public function pldAlerts(): HasMany
    {
        return $this->hasMany(PldAlert::class, 'rule_id');
    }
}
