<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldClientProfile extends Model
{
    use HasUuids;

    protected $table = 'pld_client_profiles';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditClient::class, 'client_id');
    }

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\PldPolicyVersion::class, 'policy_version_id');
    }

    public function assessedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assessed_by');
    }
}
