<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditSettlement extends Model
{
    use HasUuids;

    protected $table = 'credit_settlements';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(CreditPayoffQuote::class, 'quote_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(CreditPayment::class, 'payment_id');
    }

    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'authorized_by');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'settlement_id');
    }
}
