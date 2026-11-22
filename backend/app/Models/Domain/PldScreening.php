<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldScreening extends Model
{
    use HasUuids;

    protected $table = 'pld_screenings';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditClient::class, 'client_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditLoan::class, 'loan_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'reviewed_by');
    }
}
