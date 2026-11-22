<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PldCaseEvent extends Model
{
    use HasUuids;

    protected $table = 'pld_case_events';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Domain\\PldCase::class, 'case_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'actor_id');
    }
}
