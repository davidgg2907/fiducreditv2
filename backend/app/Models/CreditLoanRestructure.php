<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLoanRestructure extends Model
{
    use HasUuids;

    protected $table = 'credit_loan_restructures';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function newTerms(): BelongsTo
    {
        return $this->belongsTo(CreditLoanTerm::class, 'new_terms_id');
    }

    public function newSchedule(): BelongsTo
    {
        return $this->belongsTo(CreditAmortizationSchedule::class, 'new_schedule_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}
