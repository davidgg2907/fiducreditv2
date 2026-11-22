<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditInterestAccrual extends Model
{
    use HasUuids;

    protected $table = 'credit_interest_accruals';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function terms(): BelongsTo
    {
        return $this->belongsTo(CreditLoanTerm::class, 'terms_id');
    }
}
