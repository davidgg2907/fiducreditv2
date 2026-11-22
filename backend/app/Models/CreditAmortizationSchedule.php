<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditAmortizationSchedule extends Model
{
    use HasUuids;

    protected $table = 'credit_amortization_schedules';

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

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'generated_by');
    }

    public function creditAmortizationInstallments(): HasMany
    {
        return $this->hasMany(CreditAmortizationInstallment::class, 'schedule_id');
    }

    public function creditLoanRestructures(): HasMany
    {
        return $this->hasMany(CreditLoanRestructure::class, 'new_schedule_id');
    }
}
