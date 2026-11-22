<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditLineMovement extends Model
{
    use HasUuids;

    protected $table = 'credit_line_movements';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(CreditLine::class, 'line_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(CreditLoan::class, 'loan_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
