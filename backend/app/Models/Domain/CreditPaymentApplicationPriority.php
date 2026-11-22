<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditPaymentApplicationPriority extends Model
{
    use HasUuids;

    protected $table = 'credit_payment_application_priorities';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function policy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditPaymentApplicationPolicy::class, 'policy_id');
    }
}
