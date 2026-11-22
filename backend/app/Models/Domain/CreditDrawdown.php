<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditDrawdown extends Model
{
    use HasUuids;

    protected $table = 'credit_drawdowns';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLine::class, 'line_id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditApplication::class, 'application_id');
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditClientBankAccount::class, 'bank_account_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'requested_by');
    }

    public function creditLoans(): HasMany
    {
        return $this->hasMany(CreditLoan::class, 'drawdown_id');
    }

    public function creditLoanLedgerEntries(): HasMany
    {
        return $this->hasMany(CreditLoanLedgerEntry::class, 'drawdown_id');
    }

    public function pldMonitoringEvents(): HasMany
    {
        return $this->hasMany(PldMonitoringEvent::class, 'drawdown_id');
    }
}
