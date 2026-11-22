<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditApplicationFinancialSummary extends Model
{
    use HasUuids;

    protected $table = 'credit_application_financial_summaries';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditApplication::class, 'application_id');
    }

    public function analyzedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'analyzed_by');
    }
}
