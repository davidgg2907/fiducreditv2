<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditContract extends Model
{
    use HasUuids;

    protected $table = 'credit_contracts';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(CreditLine::class, 'line_id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'application_id');
    }

    public function creditLoans(): HasMany
    {
        return $this->hasMany(CreditLoan::class, 'contract_id');
    }
}
