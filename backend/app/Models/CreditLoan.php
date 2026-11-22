<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLoan extends Model
{
    use HasUuids;

    protected $table = 'credit_loans';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(CreditLine::class, 'line_id');
    }

    public function drawdown(): BelongsTo
    {
        return $this->belongsTo(CreditDrawdown::class, 'drawdown_id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'application_id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(CreditContract::class, 'contract_id');
    }

    public function creditLineMovements(): HasMany
    {
        return $this->hasMany(CreditLineMovement::class, 'loan_id');
    }

    public function creditLoanTerms(): HasMany
    {
        return $this->hasMany(CreditLoanTerm::class, 'loan_id');
    }

    public function creditAmortizationSchedules(): HasMany
    {
        return $this->hasMany(CreditAmortizationSchedule::class, 'loan_id');
    }

    public function creditAmortizationInstallments(): HasMany
    {
        return $this->hasMany(CreditAmortizationInstallment::class, 'loan_id');
    }

    public function creditInterestAccruals(): HasMany
    {
        return $this->hasMany(CreditInterestAccrual::class, 'loan_id');
    }

    public function creditPenaltyAccruals(): HasMany
    {
        return $this->hasMany(CreditPenaltyAccrual::class, 'loan_id');
    }

    public function creditLoanBalances(): HasMany
    {
        return $this->hasMany(CreditLoanBalance::class, 'loan_id');
    }

    public function creditDelinquencySnapshots(): HasMany
    {
        return $this->hasMany(CreditDelinquencySnapshot::class, 'loan_id');
    }

    public function creditLoanRateRevisions(): HasMany
    {
        return $this->hasMany(CreditLoanRateRevision::class, 'loan_id');
    }

    public function creditPayments(): HasMany
    {
        return $this->hasMany(CreditPayment::class, 'loan_id');
    }

    public function creditPaymentAllocations(): HasMany
    {
        return $this->hasMany(CreditPaymentAllocation::class, 'loan_id');
    }

    public function creditLoanLedgerEntries(): HasMany
    {
        return $this->hasMany(CreditLoanLedgerEntry::class, 'loan_id');
    }

    public function creditLoanEvents(): HasMany
    {
        return $this->hasMany(CreditLoanEvent::class, 'loan_id');
    }

    public function creditPayoffQuotes(): HasMany
    {
        return $this->hasMany(CreditPayoffQuote::class, 'loan_id');
    }

    public function creditSettlements(): HasMany
    {
        return $this->hasMany(CreditSettlement::class, 'loan_id');
    }

    public function creditLoanRestructures(): HasMany
    {
        return $this->hasMany(CreditLoanRestructure::class, 'loan_id');
    }

    public function creditLoanAdjustments(): HasMany
    {
        return $this->hasMany(CreditLoanAdjustment::class, 'loan_id');
    }

    public function pldScreenings(): HasMany
    {
        return $this->hasMany(PldScreening::class, 'loan_id');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'loan_id');
    }
}
