<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLoanLedgerEntry extends Model
{
    use HasUuids;

    protected $table = 'credit_loan_ledger_entries';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoan::class, 'loan_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditPayment::class, 'payment_id');
    }

    public function drawdown(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditDrawdown::class, 'drawdown_id');
    }

    public function reversalOf(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoanLedgerEntry::class, 'reversal_of_id');
    }

    public function creditLoanLedgerEntries(): HasMany
    {
        return $this->hasMany(CreditLoanLedgerEntry::class, 'reversal_of_id');
    }
}
