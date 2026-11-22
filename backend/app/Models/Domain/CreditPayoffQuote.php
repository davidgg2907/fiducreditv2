<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditPayoffQuote extends Model
{
    use HasUuids;

    protected $table = 'credit_payoff_quotes';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoan::class, 'loan_id');
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'generated_by');
    }

    public function creditPayoffQuoteItems(): HasMany
    {
        return $this->hasMany(CreditPayoffQuoteItem::class, 'quote_id');
    }

    public function creditSettlements(): HasMany
    {
        return $this->hasMany(CreditSettlement::class, 'quote_id');
    }
}
