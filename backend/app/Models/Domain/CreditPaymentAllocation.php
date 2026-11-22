<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditPaymentAllocation extends Model
{
    use HasUuids;

    protected $table = 'credit_payment_allocations';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditPayment::class, 'payment_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoan::class, 'loan_id');
    }

    public function installment(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditAmortizationInstallment::class, 'installment_id');
    }
}
