<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldProductPolicy extends Model
{
    use HasUuids;

    protected $table = 'pld_product_policies';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(CreditProductVersion::class, 'product_version_id');
    }

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(PldPolicyVersion::class, 'policy_version_id');
    }
}
