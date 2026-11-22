<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditClientAddress extends Model
{
    use HasUuids;

    protected $table = 'credit_client_addresses';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(CreditClient::class, 'client_id');
    }

    public function creditClientAddressVersions(): HasMany
    {
        return $this->hasMany(CreditClientAddressVersion::class, 'address_id');
    }
}
