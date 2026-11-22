<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditClientAddressVersion extends Model
{
    use HasUuids;

    protected $table = 'credit_client_address_versions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditClientAddress::class, 'address_id');
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'address_version_id');
    }
}
