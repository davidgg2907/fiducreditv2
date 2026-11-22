<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditPenaltyAccrual extends Model
{
    use HasUuids;

    protected $table = 'credit_penalty_accruals';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function installment(): BelongsTo
    {
        return $this->belongsTo(CreditAmortizationInstallment::class, 'installment_id');
    }
}
