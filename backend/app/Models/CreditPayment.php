<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditPayment extends Model
{
    use HasUuids;

    protected $table = 'credit_payments';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(CreditLine::class, 'line_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(CreditPaymentChannel::class, 'channel_id');
    }

    public function sourceBankAccount(): BelongsTo
    {
        return $this->belongsTo(CreditClientBankAccount::class, 'source_bank_account_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'recorded_by');
    }

    public function creditPaymentAllocations(): HasMany
    {
        return $this->hasMany(CreditPaymentAllocation::class, 'payment_id');
    }

    public function creditLoanLedgerEntries(): HasMany
    {
        return $this->hasMany(CreditLoanLedgerEntry::class, 'payment_id');
    }

    public function creditSettlements(): HasMany
    {
        return $this->hasMany(CreditSettlement::class, 'payment_id');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'payment_id');
    }
}
