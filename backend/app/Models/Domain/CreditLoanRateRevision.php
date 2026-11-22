<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLoanRateRevision extends Model
{
    use HasUuids;

    protected $table = 'credit_loan_rate_revisions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoan::class, 'loan_id');
    }

    public function terms(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoanTerm::class, 'terms_id');
    }

    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'authorized_by');
    }
}
