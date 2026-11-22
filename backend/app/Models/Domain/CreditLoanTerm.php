<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLoanTerm extends Model
{
    use HasUuids;

    protected $table = 'credit_loan_terms';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoan::class, 'loan_id');
    }

    public function creditAmortizationSchedules(): HasMany
    {
        return $this->hasMany(CreditAmortizationSchedule::class, 'terms_id');
    }

    public function creditInterestAccruals(): HasMany
    {
        return $this->hasMany(CreditInterestAccrual::class, 'terms_id');
    }

    public function creditLoanRateRevisions(): HasMany
    {
        return $this->hasMany(CreditLoanRateRevision::class, 'terms_id');
    }

    public function creditLoanRestructures(): HasMany
    {
        return $this->hasMany(CreditLoanRestructure::class, 'new_terms_id');
    }
}
