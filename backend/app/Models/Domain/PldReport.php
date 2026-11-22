<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldReport extends Model
{
    use HasUuids;

    protected $table = 'pld_reports';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\PldCase::class, 'case_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\CreditCompany::class, 'company_id');
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'prepared_by');
    }
}
