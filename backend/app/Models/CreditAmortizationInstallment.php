<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditAmortizationInstallment extends Model
{
    use HasUuids;

    protected $table = 'credit_amortization_installments';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(CreditAmortizationSchedule::class, 'schedule_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function creditPenaltyAccruals(): HasMany
    {
        return $this->hasMany(CreditPenaltyAccrual::class, 'installment_id');
    }

    public function creditPaymentAllocations(): HasMany
    {
        return $this->hasMany(CreditPaymentAllocation::class, 'installment_id');
    }
}
